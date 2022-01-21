<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('notification_settings')->insert([
            'options' => '{"mmr":null,"minimum_slp":null,"target_slp_price":null,"target_slp_unit":null}',
            'type' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('notification_settings')->insert([
            'options' => '{"mmr":null,"minimum_slp":null,"target_slp_price":null,"target_slp_unit":null}',
            'type' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
