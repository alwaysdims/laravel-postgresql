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
            'code_major' => 'TKJ',
            'name' => 'Teknik Komputer Jaringan'
        ]);

        Major::create([
            'code_major' => 'MM',
            'name' => 'Multimedia'
        ]);
    }
}
