<?php

namespace App\Models;

use App\Enums\OrderCategory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_category_id',
        'name',
        'description',
        'base_unit',
        'display_unit',
        'conversion',
    ];

    protected $casts = [
        'order_category' => OrderCategory::class,
    ];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id', 'id');
    }
}
