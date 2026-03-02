<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributionRoute extends Model
{
    protected $fillable = [
        'route_name',
        'is_active',
    ];

    public function school_routes()
    {
        return $this->hasMany(SchoolRoute::class, 'route_id', 'id');
    }

    public function posyandu_routes()
    {
        return $this->hasMany(PosyanduRoute::class, 'route_id', 'id');
    }

    public function schools()
    {
        return $this->belongsToMany(
            School::class,
            'school_routes',
            'route_id',
            'school_id'
        )->withPivot('delivery_order')
        ->withTimestamps()
        ->orderByPivot('delivery_order');
    }

    public function posyandus()
    {
        return $this->belongsToMany(
            Posyandu::class,
            'posyandu_routes',
            'route_id',
            'posyandu_id'
        )->withPivot('delivery_order')
        ->withTimestamps()
        ->orderByPivot('delivery_order');
    }

}
