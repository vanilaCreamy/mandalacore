<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posyandu extends Model
{
    use SoftDeletes;

    protected $table = 'posyandu';

    protected $fillable = [
        'posyandu_code',
        'posyandu_name',
        'address',
        'cadre_name',
        'cadre_phone_number',
        'cadre_email',
        'route',
    ];

    public function portions(){
        return $this->hasMany(PosyanduPortion::class, 'posyandu_id', 'id');
    }

    public function posyandu_logs()
    {
        return $this->hasMany(PosyanduDelivery::class);
    }
}
