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
            'first_name' => 'Super',
            'middle_name' => '',
            'last_name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('@Dm1nsUp3RR'),
            'role' => 1
        ]);

        User::create([
            'first_name' => 'Decent',
            'middle_name' => '',
            'last_name' => 'Admin',
            'username' => 'decent_admin',
            'password' => bcrypt('@dm1nd3c3N+'),
            'type' => 1
        ]);

        User::create([
            'first_name' => 'Trust',
            'middle_name' => '',
            'last_name' => 'Admin',
            'username' => 'trust_admin',
            'password' => bcrypt('Adm1n+Ru$t'),
            'type' => 2
        ]);
    }
}
