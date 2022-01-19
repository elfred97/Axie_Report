<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CreateDatabaseCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('slp-update')->everyMinute()->runInBackground()->withoutOverlapping();
        $schedule->command('remind-payroll')->monthlyOn(10, '08:00')->runInBackground()->withoutOverlapping();
        $schedule->command('reminders:check-and-send')->everyMinute()->runInBackground()->withoutOverlapping();
        $schedule->command('api.logs')->dailyAt('8:30')->runInBackground()->withoutOverlapping(); //needs to check reminder schedule so need to run every minute
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
