<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRequest extends Model
{
    use HasFactory;

    protected $table = 'permission_requests';

    protected $fillable = [
        'student_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'attachment',
        'status',
        'note',
        'approval_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approval_date' => 'date',
    ];

    // Relasi ke siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Cek apakah sudah disetujui
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    // Cek apakah ditolak
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Cek apakah masih menunggu
    public function isPending()
    {
        return $this->status === 'pending';
    }
}
