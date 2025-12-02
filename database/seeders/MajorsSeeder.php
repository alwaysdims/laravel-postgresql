<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorsSeeder extends Seeder
{
    public function run(): void
    {
        Major::create([
            'code_major' => 'RPL',
            'name' => 'Rekayasa Perangkat Lunak'
        ]);

        Major::create([
            'code_major' => 'OT',
            'name' => 'Teknik Ototronik'
        ]);

        Major::create([
            'code_major' => 'TPK',
            'name' => 'Teknik Pembuatan Kain'
        ]);
        Major::create([
            'code_major' => 'TM',
            'name' => 'Teknik Mesin'
        ]);
    }
}
