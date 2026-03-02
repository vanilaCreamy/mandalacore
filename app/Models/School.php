<?php

namespace App\Models;

use App\enum\SchoolLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;
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
        'route',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'school_level' => SchoolLevel::class,
        ];
    }

    public function portions()
    {
        return $this->hasMany(SchoolPortion::class);
    }
}
