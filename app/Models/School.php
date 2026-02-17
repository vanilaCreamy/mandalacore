<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'school_code',
        'school_name',
        'address',
        'school_level',
        'small_portions',
        'big_portions',
        'teacher_portions',
        'non_teacher_portions',
        'pic_name',
        'pic_position',
        'pic_phone_number',
        'pic_email',
        'hm_name',
        'hm_phone_number',
        'hm_email',
    ];
}
