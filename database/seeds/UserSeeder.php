<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('user')->insert([
            'first_name' => 'Admin',
            'middle_name' => 'A',
            'last_name' => 'Axie Report',
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
    }
}
