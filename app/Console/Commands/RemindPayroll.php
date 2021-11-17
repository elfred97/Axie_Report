<?php

namespace App\Console\Commands;

use App\Models\Scholar;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RemindPayroll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind-payroll {type? : Type Id of scholars}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send email to all scholar about payroll.';

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
        $this->line('Payroll Reminder Start: ' . Carbon::now()->format('Y-m-d H:i:s'));

        $type = $this->argument('type');

        $scholars = Scholar::when($type,function($q, $type){
            $q->where('type_id','=', $type);
        })->get();

        $scholar_emails = $scholars->pluck('email');

        $this->line('Sending to : ' . $scholar_emails );

        if($scholar_emails) {
            Mail::to($scholar_emails)->send(new \App\Mail\PayrollReminder(null));
        }
//        foreach ($scholars as $scholar) {
//          Mail::to($scholar_emails)->send(new \App\Mail\PayrollReminder($scholar));
//        }

        $this->line('Payroll Reminder End: ' . Carbon::now()->format('Y-m-d H:i:s'));
        return 0;
    }
}
