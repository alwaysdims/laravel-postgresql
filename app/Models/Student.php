<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'nis',
        'class_id',
        'major_id',
    ];
}
