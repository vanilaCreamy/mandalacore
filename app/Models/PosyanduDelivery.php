<?php

namespace App\Models;

use App\enum\DriverCategory;
use App\enum\DriverFlow;
use Illuminate\Database\Eloquent\Model;

class PosyanduDelivery extends Model
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
        'posyandu_id',
        'amount_bumil',
        'amount_busui',
        'driver_balita',
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
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');

    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function prevLog()
    {
        return $this->belongsTo(SchoolDelivery::class, 'prev_log_id', 'id');
    }
}
