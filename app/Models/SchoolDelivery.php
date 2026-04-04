<?php

namespace App\Models;

use App\Enums\DriverCategory;
use App\Enums\DriverFlow;
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
        'prev_log_id',
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

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    public function prev_log()
    {
        return $this->belongsTo(SchoolDelivery::class, 'prev_log_id', 'id');
    }
}
