<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeachersSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::create([
            'user_id' => 2,
            'nip' => '197801012001',
            'name' => 'Budi Santoso',
            'subjects_id' => 1,
            'address' => 'Jl. Pendidikan No. 5',
            'number_phone' => '081223344556'
        ]);
    }
}
