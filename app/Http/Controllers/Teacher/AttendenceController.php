<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendenceController extends Controller
{
    public function index(Request $request)
    {
        // Default tanggal = hari ini
        $date = $request->date ?? Carbon::today()->toDateString();
        $status = $request->status;

        $attendances = Attendance::with(['student.user', 'student.classes'])
            ->whereDate('date', $date)
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('check_in_time', 'asc')
            ->get();

        return view('teacher.data-absensi', compact(
            'attendances',
            'date',
            'status'
        ));
    }
}
