<?php

namespace App\Models;


use App\Enums\DriverCategory;
use App\Enums\DriverFlow;
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
        'amount_balita',
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
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');

    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    public function prev_log()
    {
        return $this->belongsTo(PosyanduDelivery::class, 'prev_log_id', 'id');
    }
}
