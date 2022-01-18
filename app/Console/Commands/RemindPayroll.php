<?php

namespace App\Console\Commands;

use App\Models\Payroll;
use App\Models\Player;
use App\Models\Scholar;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

        //get scholar share on players table
        //put it on payroll table, tx_id is a unique generated string
        //make player.scholar_share = 0 after creating entry to payroll

        $players = Player::where('scholar_share','>',0)->get();

        foreach ($players as $player) {
            $total_slp = $player->scholar_share;

            try {
                DB::beginTransaction();
                Payroll::create([
                    'player_id' => $player->id,
                    'scholar_id' => $player->latestHistory()->scholar_id,
                    'total_slp' => $total_slp,
                    'txn_id' => NULL,
                    // 'txn_id' => $player->id . '-' . $player->latestHistory()->scholar_id . '-' . uniqid() . time(),
                    'status' => 0
                ]);

//                TODO - uncomment this
               $player->scholar_share = 0;
               $player->save();

                DB::commit();
            } catch (\Exception $e) {
                $this->line('Error : ' . $e->getMessage());
                DB::rollBack();
            }
        }


//        $scholars = Scholar::when($type, function ($q, $type) {
//            $q->where('type_id', '=', $type);
//        })->get();
//
//        $scholar_emails = $scholars->pluck('email');
//
//        $this->line('Sending to : ' . $scholar_emails);

        //temporary for testing cron job
//        $scholar_emails = ['mhardz07@gmail.com'];
//        if($scholar_emails) {
//            Mail::to($scholar_emails)->send(new \App\Mail\PayrollReminder(null));
//        }


        $payrolls = Payroll::all();

        foreach ($payrolls as $payroll) {
            try {
                $scholar = $payroll->scholar;
                Mail::to($scholar->email)->send(new \App\Mail\PayrollReminder($scholar, $payroll));
                $this->line('Sending Payroll email to: ' . $scholar->email);
            } catch (\Exception $e) {
                $this->line('Error sending email to: ' . $scholar->email);
                $this->line('Error : ' . $e->getMessage());
            }
        }
//         **/
//
//        $scholars = [new Scholar(['email' => 'mhardz07@gmail.com', 'first_name' => 'Mardy']), new Scholar(['email' => 'elfredtapar@gmail.com', 'first_name' => 'Elfred'])];
//
//
//        foreach ($scholars as $scholar) {
//            try {
//                Mail::to($scholar)->send(new \App\Mail\PayrollReminder($scholar, new Payroll(['total_slp' => 10])));
//            } catch (\Exception $e) {
//                $this->line('Error sending email to: ' . $scholar->email);
//                $this->line('Error : ' . $e->getMessage());
//            }
//        }

        $this->line('Payroll Reminder End: ' . Carbon::now()->format('Y-m-d H:i:s'));
        return 0;
    }
}
