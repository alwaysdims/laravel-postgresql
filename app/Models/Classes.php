<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'class';

    protected $fillable = [
        'name',
        'major_id',
        'teacher_id',
    ];
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

}
