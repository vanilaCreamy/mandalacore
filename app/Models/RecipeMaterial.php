<?php

namespace App\Models;

use App\Models\Material;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;

class RecipeMaterial extends Model
{
    protected $fillable = [
        'recipe_id',
        'material_id',
        'qty_gram',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}
