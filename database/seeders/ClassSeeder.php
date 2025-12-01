<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan model: Class → Classes (atau sesuaikan)

        Kelas::create([
            'name' => 'X RPL 1',
            'major_id' => 1
        ]);

        Kelas::create([
            'name' => 'XI TKJ 1',
            'major_id' => 2
        ]);

        Kelas::create([
            'name' => 'XII MM 1',
            'major_id' => 3
        ]);
    }
}
