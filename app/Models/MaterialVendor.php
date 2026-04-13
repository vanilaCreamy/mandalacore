<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialVendor extends Model
{
    protected $table = 'materials_vendors';

    protected $fillable = [
        'vendor_id',
        'material_id',
    ];
}
