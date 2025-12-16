<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan model: Class → Classes (atau sesuaikan)

        Classes::create([
            'name' => 'XII RB',
            'major_id' => 1,
            'teacher_id' => 1
        ]);
    }
}
