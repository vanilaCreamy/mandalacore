<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortionBase extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];
}
