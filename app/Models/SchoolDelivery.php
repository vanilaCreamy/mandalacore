<?php

namespace App\Models;

use App\enum\DriverCategory;
use App\enum\DriverFlow;
use App\Models\School;
use Illuminate\Database\Eloquent\Model;

class SchoolDelivery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'timestamp',
        'category',
        'flow',
        'school_id',
        'amount_pk',
        'amount_pb',
        'driver_id',
        'latitude',
        'longitude',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => DriverCategory::class,
            'flow' => DriverFlow::class,
        ];
    }

    // RELATIONSHIP
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');

    }
}
