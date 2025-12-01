<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectsSeeder extends Seeder
{
    public function run(): void
    {
        Subject::create([
            'code_subject' => 'MTK01',
            'name' => 'Matematika'
        ]);

        Subject::create([
            'code_subject' => 'ENG01',
            'name' => 'Bahasa Inggris'
        ]);

        Subject::create([
            'code_subject' => 'PKN01',
            'name' => 'PPKn'
        ]);
    }
}
