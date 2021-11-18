<?php

namespace App\Console\Commands;

use App\Models\Scholar;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SlpUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slp-update {type?} : Type Id of scholars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will send an email update for SLP to each scholars';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('SLP Update Start: ' . Carbon::now()->format('Y-m-d H:i:s'));

        $type = $this->argument('type');

        $scholars = Scholar::when($type,function($q, $type){
            $q->where('type_id','=', $type);
        })->get();

        $scholar_emails = $scholars->pluck('email');

        $this->line('Sending to : ' . $scholar_emails );

        $response = Http::get('https://api.coingecko.com/api/v3/simple/price?ids=smooth-love-potion&vs_currencies=php');
        if($response->failed()) {
            $this->error('Error: Can not access coingecko' );
            $this->line('SLP Update End: ' . Carbon::now()->format('Y-m-d H:i:s'));
            return  1;
        }

        $json_response = $response->json();
        $slp_price = $json_response['smooth-love-potion']['php'];

        //temporary for testing cron job
        $scholar_emails = ['mhardz07@gmail.com'];

        if($scholar_emails) {
            Mail::to($scholar_emails)->send(new \App\Mail\SlpUpdate(null, $slp_price));
        }
//        foreach ($scholars as $scholar) {
//
//        }

        $this->line('SLP Update End: ' . Carbon::now()->format('Y-m-d H:i:s'));
        return 0;

    }
}
