<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'subjects_id',
        'address',
        'number_phone',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class,'subjects_id');
    }
}
