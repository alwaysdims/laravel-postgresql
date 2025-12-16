<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',

        // Check In
        'check_in_time',
        'check_in_photo',
        'check_in_latitude',
        'check_in_longitude',

        // Check Out
        'check_out_time',
        'check_out_photo',
        'check_out_latitude',
        'check_out_longitude',

        'status',
    ];

    // Relasi ke tabel students
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Untuk mengecek apakah siswa sudah absen masuk
    public function isCheckedIn()
    {
        return !is_null($this->check_in_time);
    }

    // Untuk mengecek apakah siswa sudah absen pulang
    public function isCheckedOut()
    {
        return !is_null($this->check_out_time);
    }

    // Format otomatis tanggal ke date Y-m-d
    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];
}
