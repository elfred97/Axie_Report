<?php

use App\Models\User;
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

        User::create([
            'first_name' => 'Admin',
            'middle_name' => 'A',
            'last_name' => 'Axie Report',
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);
    }
}
