<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosyanduRoute extends Model
{
    protected $fillable = [
        'route_id',
        'posyandu_id',
    ];

    public function route()
    {
        return $this->belongsTo(DistributionRoute::class, 'route_id', 'id');
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id', 'id');
    }
}
