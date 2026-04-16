<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuExtraMaterial extends Model
{
    protected $fillable = [
        'menu_id',
        'material_id',
        'portion_base_id',
        'qty_gram',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}
