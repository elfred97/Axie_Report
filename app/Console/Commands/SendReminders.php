<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Reminder;
use App\Models\Scholar;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:check-and-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will check for reminders that need to be send.';

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
        $this->line('Send Reminder Start: ' . \Carbon\Carbon::now()->format('Y-m-d H:i:s'));


        $reminders = Reminder::all();
       $current_date = Carbon::now();

//        $scholars = [new Scholar(['email' => 'mhardz07@gmail.com', 'first_name' => 'Mardy']), new Scholar(['email' => 'elfredtapar@gmail.com', 'first_name' => 'Elfred'])];

            foreach ($reminders as $reminder) {
                $reminder_time = \Carbon\Carbon::parse($reminder->reminder_time);
                $recurrence = $reminder->recurrence;

//                $this->info('Type : ' . $recurrence);
//                $this->info('once : ' . ($recurrence == Reminder::RECURRENCE_ONCE && $reminder_time->format('Y-m-d H:i') ==$current_date->format('Y-m-d H:i') ? 'true' : 'false'));
//                $this->info('daily : ' . ($recurrence == Reminder::RECURRENCE_DAILY && $reminder_time->format('H:i') ==$current_date->format('H:i')? 'true' : 'false'));
//                $this->info('weekly : ' . ($recurrence == Reminder::RECURRENCE_WEEKLY && $reminder_time->format('l H:i') ==$current_date->format('l H:i')? 'true' : 'false'));
//                $this->info('monthly : ' . ($recurrence == Reminder::RECURRENCE_MONTHLY && $reminder_time->format('d H:i') ==$current_date->format('d H:i')? 'true' : 'false'));

                if (
                    ($recurrence == Reminder::RECURRENCE_ONCE && $reminder_time->format('Y-m-d H:i') == $current_date->format('Y-m-d H:i'))
                    || ($recurrence == Reminder::RECURRENCE_DAILY && $reminder_time->format('H:i') == $current_date->format('H:i'))
                    || ($recurrence == Reminder::RECURRENCE_WEEKLY && $reminder_time->format('l H:i') == $current_date->format('l H:i'))
                    || ($recurrence == Reminder::RECURRENCE_MONTHLY && $reminder_time->format('d H:i') == $current_date->format('d H:i'))
                ) {
                   $this->info('Sending Reminder with id : ' . $reminder->id);

                    $type = $reminder->type_id;
                    $scholars = Scholar::when($type, function ($q, $type) {
                        $q->where('type_id', '=', $type);
                    })->get();

                    Notification::create([
                        'reminder_id' => $reminder->id,
                        'category' => 3
                    ]);
                    foreach ($scholars as $scholar) {
                        Mail::to($scholar->email)->send(new \App\Mail\SendEmailReminder($scholar, $reminder));
                        $this->info('Sending Reminder with id : ' . $reminder->id . ' to ' . $scholar->email);
                    }
                }

                $this->info('');

            }

        $this->line('Send Reminder End: ' . \Carbon\Carbon::now()->format('Y-m-d H:i:s'));
        return 0;
    }
}
