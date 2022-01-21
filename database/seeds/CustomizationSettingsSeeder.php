<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomizationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customization_settings')->insert([
            'options' => '{"total_slp":true,"total_unclaimed":true,"total_claimed":true,"total_slp_today":true,"total_slp_yesterday":true,"total_average":true,"penalty":true,"lowest_mmr":true}',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('customization_settings')->insert([
            'options' => '{"total_slp":true,"total_unclaimed":true,"total_claimed":true,"total_slp_today":true,"total_slp_yesterday":true,"total_average":true,"penalty":true,"lowest_mmr":true}',
            'user_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('customization_settings')->insert([
            'options' => '{"total_slp":true,"total_unclaimed":true,"total_claimed":true,"total_slp_today":true,"total_slp_yesterday":true,"total_average":true,"penalty":true,"lowest_mmr":true}',
            'user_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
