<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendancesSeeder extends Seeder
{
    public function run(): void
    {
        Attendance::create([
            'student_id' => 1,
            'date' => Carbon::now(),
            'status' => 'hadir',
            'foto' => 'foto1.jpg',
            'latitude' => '-7.123456',
            'longitude' => '110.987654',
        ]);

        Attendance::create([
            'student_id' => 2,
            'date' => Carbon::now()->subDay(),
            'status' => 'izin',
            'foto' => 'foto2.jpg',
            'latitude' => '-7.124000',
            'longitude' => '110.980000',
        ]);

        Attendance::create([
            'student_id' => 3,
            'date' => Carbon::now()->subDays(2),
            'status' => 'alpha',
            'foto' => 'foto3.jpg',
            'latitude' => '-7.120000',
            'longitude' => '110.970000',
        ]);
    }
}
