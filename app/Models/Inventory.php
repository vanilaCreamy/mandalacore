<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'material_id',
        'ref_type',
        'ref_id',
        'date',
        'qty_in',
        'qty_out',
        'balance'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
