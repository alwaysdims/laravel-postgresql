<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;

class GenerateDailyAttendance extends Command
{
    protected $signature = 'attendance:generate-daily';
    protected $description = 'Generate attendance records for all students every day';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $students = Student::all();

        foreach ($students as $student) {
            Attendance::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'date' => $today
                ],
                [
                    'status' => 'alpha',
                ]
            );
        }

        $this->info("Attendance generated for {$today}");
    }
}
