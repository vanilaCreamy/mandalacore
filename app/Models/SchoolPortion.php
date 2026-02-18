<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolPortion extends Model
{
    protected $fillable = [
        'school_id',
        'small_portions',
        'big_portions',
        'teacher_portions',
        'non_teacher_portions',
    ];

    public function school()
    {
        return $this->hasOne(School::class, 'id', 'school_id');
    }
}
