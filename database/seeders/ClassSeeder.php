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
            'name' => 'X RB',
            'major_id' => 1
        ]);

        Classes::create([
            'name' => 'XI OA',
            'major_id' => 2
        ]);

        Classes::create([
            'name' => 'XII TC',
            'major_id' => 3
        ]);
    }
}
