<?php

namespace App\Models;

use App\Enums\SchoolLevel;
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
        'pic_name',
        'pic_position',
        'pic_phone_number',
        'pic_email',
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

    public function school_logs()
    {
        return $this->hasMany(SchoolDelivery::class);
    }
}
