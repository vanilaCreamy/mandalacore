<?php

namespace App\Models;

use App\Models\MenuItem;
use App\Models\MenuPortion;
use App\Models\RecipePortionBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Collection;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'date',
        'description',
    ];

    public function generateMaterialNeeds(): Collection
    {
        $materials = collect();

        $this->loadMissing([
            'items.recipe.recipe_materials.material',
            'portions.portion_base',
            'extraMaterials.material',
        ]);

        foreach ($this->items as $item) {
            foreach ($item->recipe->recipe_materials as $rm) {

                foreach ($this->portions as $portion) {

                    $recipeMultiplier = RecipePortionBase::where([
                        'recipe_id' => $item->recipe_id,
                        'portion_base_id' => $portion->portion_base_id,
                    ])->value('multiplier') ?? 1;

                    $totalGram =
                        $rm->qty_gram *
                        $recipeMultiplier *
                        $portion->total_portions;

                    $materials->push([
                        'material_id' => $rm->material_id,
                        'material'    => $rm->material,
                        'total_gram'  => $totalGram,
                    ]);
                }
            }
        }

        // EXTRA MATERIALS (buah, susu, dll)
        foreach ($this->extraMaterials as $extra) {

            $portion = $this->portions
                ->where('portion_base_id', $extra->portion_base_id)
                ->first();

            if (!$portion) continue;

            $totalGram = $extra->qty_gram * $portion->total_portions;

            $materials->push([
                'material_id' => $extra->material_id,
                'material'    => $extra->material,
                'total_gram'  => $totalGram,
            ]);
        }

        return $materials
            ->groupBy('material_id')
            ->map(function ($rows) {

                $material = $rows->first()['material'];
            
                if (!$material) {
                    return null; // skip kalau ada data rusak
                }
            
                $totalGram = $rows->sum('total_gram');
                $totalDisplayUnit = $totalGram / $material->conversion;
            
                return [
                    'material_name'   => $material->name,
                    'display_unit'    => $material->display_unit,
                    'total_gram'      => $totalGram,
                    'total_display'   => round($totalDisplayUnit, 2),
                ];
            })
            ->filter()
            ->values();
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id');
    }

    public function portions()
    {
        return $this->hasMany(MenuPortion::class, 'menu_id', 'id');
    }

    public function extraMaterials()
    {
        return $this->hasMany(MenuExtraMaterial::class);
    }
}
