<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'user_id' => 3,
            'nis' => '220001',
            'nama' => 'Dimas Pratama',
            'class_id' => 1
        ]);

    }
}
