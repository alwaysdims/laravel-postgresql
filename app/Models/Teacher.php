<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'subject',
        'address',
        'number_phone',
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
