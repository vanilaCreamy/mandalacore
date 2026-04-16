<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipePortionBase extends Model
{
    protected $fillable = [
        'recipe_id',
        'portion_base_id',
        'multiplier',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }

    public function portion_base()
    {
        return $this->belongsTo(PortionBase::class, 'portion_base_id', 'id');
    }
}
