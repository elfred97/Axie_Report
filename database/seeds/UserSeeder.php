<?php

use Illuminate\Database\Seeder;

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
            'first_name' => 'Mardy',
            'middle_name' => 'A',
            'last_name' => 'dela Cruz',
            'username' => 'mhardz',
            'password' => bcrypt('123456')
        ]);

        DB::table('user')->insert([
            'first_name' => 'Admin',
            'middle_name' => 'A',
            'last_name' => 'Axie Report',
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
    }
}
