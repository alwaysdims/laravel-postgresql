<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code_subject',
    ];

    public function teachers(){
        return $this->hasMany(Teacher::class,'subjects_id');
    }
}
