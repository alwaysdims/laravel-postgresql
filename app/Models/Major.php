<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [
        'name',
        'code_major',
    ];
    public function classes()
    {
        return $this->hasMany(Classes::class, 'major_id');
    }
}
