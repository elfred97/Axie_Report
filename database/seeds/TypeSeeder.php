<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'Trust',
            'status' => 'Active'
        ]);
        Type::create([
            'name' => 'Decent',
            'status' => 'Active'
        ]);
    }
}
