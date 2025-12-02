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

        Teacher::create([
            'user_id' => 2,
            'nip' => '198002022002',
            'name' => 'Sri Wahyuni',
            'subjects_id' => 2,
            'address' => 'Jl. Pendidikan No. 10',
            'number_phone' => '081334455667'
        ]);

        Teacher::create([
            'user_id' => 2,
            'nip' => '198503032003',
            'name' => 'Agus Pribadi',
            'subjects_id' => 3,
            'address' => 'Jl. Pendidikan No. 12',
            'number_phone' => '081445566778'
        ]);
    }
}
