<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create_tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the migrations in the order';

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
     * @return mixed
     */
    public function handle()
    {
       /** Specify the names of the migrations files in the order you want to 
        * loaded
        * $migrations =[ 
        *               'xxxx_xx_xx_000000_create_nameTable_table.php',
        *    ];
        */
        $migrations = [ 
                        '2021_10_10_170911_create_user_table.php',
                        '2021_11_03_085634_create_type_table.php',
                        '2014_10_12_100000_create_password_resets_table.php',
                        '2021_10_07_091051_create_report_table.php',
                        '2021_10_10_170549_create_player_table.php',
                        '2021_11_08_124812_create_scholars_table.php',
                        '2021_11_10_004335_create_playerscholarhistories_table.php',
                        '2021_11_24_135540_create_payroll.php',
                        '2021_11_03_090327_create_notification_settings_table.php',
                        '2021_10_21_081743_create_notification_table.php',
                        '2022_01_14_111403_create_notification_scholars_table.php',
                        '2021_11_22_133852_create_reminders.php',
                        '2021_12_29_143012_create_api_logs.php',
                        '2021_11_29_143511_create_slp_price_notification_histories.php'
                    ];

        foreach($migrations as $migration)
        {
           $basePath = 'database/migrations/';          
           $migrationName = trim($migration);
           $path = $basePath.$migrationName;
           $this->call('migrate', [
            '--path' => $path ,            
           ]);
        }
    }
} 