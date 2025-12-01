<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'user_id' => 1,
            'name' => 'Admin Utama',
            'address' => 'Jl. Mawar 12',
            'number_phone' => '081234567890'
        ]);

        Admin::create([
            'user_id' => 1,
            'name' => 'Admin Kedua',
            'address' => 'Jl. Melati 45',
            'number_phone' => '082345678901'
        ]);

        Admin::create([
            'user_id' => 1,
            'name' => 'Admin Ketiga', 
            'address' => 'Jl. Kenanga 9',
            'number_phone' => '083456789012'
        ]);
    }
}
