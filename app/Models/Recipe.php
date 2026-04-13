<?php

namespace App\Models;

use App\Models\RecipeMaterial;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name'];

    public function recipe_materials()
    {
        return $this->hasMany(RecipeMaterial::class, 'recipe_id', 'id');
    }
}
