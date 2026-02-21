<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosyanduPortion extends Model
{
    protected $table = 'posyandu_portions';

    protected $fillable = [
        'posyandu_id',
        'bumil',
        'busui',
        'balita',
    ];

    public function posyandu(){
        return $this->belongsTo(Posyandu::class, 'posyandu_id', 'id');
    }
}
