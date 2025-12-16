<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\PermissionRequest;
use App\Http\Controllers\Controller;

class AttendenceController extends Controller
{
    public function showCheckInForm(){
        return view('student.absen-masuk');
    }

    public function showCheckInOut(){
        return view('student.absen-pulang');
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        $studentId = $request->student_id;
        $today = Carbon::today()->toDateString();

        // --- Generate attendance untuk semua siswa jika belum ada
        if (Attendance::whereDate('date', $today)->count() == 0) {

            $students = Student::all();

            foreach ($students as $student) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => $today,
                    'status' => 'alpha',
                ]);
            }
        }

        // --- Ambil data attendance hari ini
        $attendance = Attendance::where('student_id', $studentId)
            ->whereDate('date', $today)
            ->first();

        if ($attendance->check_in_time !== null) {
            return back()->with('error', 'Anda sudah absen masuk hari ini.');
        }

        // Upload foto
        $fileName = 'checkin_' . $studentId . '_' . time() . '.' . $request->photo->extension();
        $path = $request->photo->storeAs('attendances/check_in', $fileName, 'public');

        // Update record
        $attendance->update([
            'check_in_time' => now(),
            'check_in_photo' => $path,
            'check_in_latitude' => $request->latitude,
            'check_in_longitude' => $request->longitude,
            'status' => 'hadir',
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Absen masuk berhasil!');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        $studentId = $request->student_id;
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('student_id', $studentId)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Data presensi tidak ditemukan.');
        }

        if ($attendance->check_out_time !== null) {
            return back()->with('error', 'Anda sudah absen pulang hari ini.');
        }

        $fileName = 'checkout_' . $studentId . '_' . time() . '.' . $request->photo->extension();
        $path = $request->photo->storeAs('attendances/check_out', $fileName, 'public');

        $attendance->update([
            'check_out_time' => now(),
            'check_out_photo' => $path,
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Absen pulang berhasil!');
    }

    public function izinShowForm()
    {
        return view('student.izin');
    }
    public function izinStore(Request $request)
    {
        // Validasi input
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:izin,sakit',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

         // Cek apakah siswa sudah mengajukan izin pada tanggal start_date
        $alreadyExists = PermissionRequest::where('student_id', $request->student_id)
        ->whereDate('start_date', $request->start_date)
        ->exists();

        if ($alreadyExists) {
            return redirect()->back()->with([
                'error' => 'Anda sudah mengajukan surat izin/sakit pada hari ini!'
            ]);
        }

        // Jika end_date kosong, otomatis isi dengan start_date
        $endDate = $request->end_date ? $request->end_date : $request->start_date;

        // Upload lampiran
        $fileName = 'izin_' . $request->student_id . '_' . time() . '.' . $request->attachment->extension();
        $path = $request->attachment->storeAs('permission_attachments', $fileName, 'public');

        // Simpan ke database
        PermissionRequest::create([
            'student_id'   => $request->student_id,
            'type'         => $request->type,
            'start_date'   => $request->start_date,
            'end_date'     => $endDate,
            'reason'       => $request->reason,
            'attachment'   => $path,
            'status'       => 'pending',   // default
            'note'         => null,
            'approval_date'=> null,
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin / sakit berhasil dikirim!');
    }

}
