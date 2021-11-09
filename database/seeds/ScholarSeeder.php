<?php

use Illuminate\Database\Seeder;

class ScholarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scholars')->insert([
            'first_name' => 'Mardy',
            'middle_name' => 'The',
            'last_name' => 'Scholar',
            'username' => 'mhardz_sko',
            'email' => 'mhardz07@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
