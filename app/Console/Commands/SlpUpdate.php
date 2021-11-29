<?php

namespace App\Console\Commands;

use App\Models\NotificationSettings;
use App\Models\Scholar;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SlpUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slp-update {type?} : Type Id of scholars {--force}';

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
        $force = $this->option('force');

        $scholars = Scholar::when($type, function ($q, $type) {
            $q->where('type_id', '=', $type);
        })->get();

//        $scholar_emails = $scholars->pluck('email');
//
//        $this->line('Sending to : ' . $scholar_emails);

        //TODO : check if already sent this day

        //slp_price_notifications_history
        //datetime, price,
        //

        $response = Http::get('https://api.coingecko.com/api/v3/simple/price?ids=smooth-love-potion&vs_currencies=php,jpy,usd');
        if ($response->failed()) {
            $this->error('Error: Can not access coingecko');
            $this->line('SLP Update End: ' . Carbon::now()->format('Y-m-d H:i:s'));
            return 1;
        }

        $json_response = $response->json();
        $slp_prices = $json_response['smooth-love-potion'];

        $this->line('Prices: ' . print_r($slp_prices, true));

        $notification_settings = NotificationSettings::firstOrNew();
        $notif_options = $notification_settings->options;

        $this->line('Options: ' . print_r($notif_options, true));

        if ($notif_options && $slp_prices[strtolower($notif_options['target_slp_unit'])] >= $notif_options['target_slp_price']) {
            $this->line('Will send email notif');
            //temporary for testing cron job
//        $scholar_emails = ['mhardz07@gmail.com','elfredtapar@gmail.com'];
//            Mail::to($scholar_emails)->send(new \App\Mail\SlpUpdate(null, $slp_price));

            //testing only for now
            $scholars = [new Scholar(['email' => 'mhardz07@gmail.com', 'first_name' => 'Mardy']), new Scholar(['email' => 'elfredtapar@gmail.com', 'first_name' => 'Elfred'])];

            if ($scholars) {
                foreach ($scholars as $scholar) {
                    Mail::to($scholar->email)->send(new \App\Mail\SlpUpdate($scholar, $slp_prices[strtolower($notif_options['target_slp_unit'])], $notif_options['target_slp_unit']));
                }
            }
        }


        $this->line('SLP Update End: ' . Carbon::now()->format('Y-m-d H:i:s'));
        return 0;

    }
}
