<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolRoute extends Model
{
    protected $fillable = [
        'route_id',
        'school_id',
    ];

    public function route()
    {
        return $this->belongsTo(DistributionRoute::class, 'route_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
