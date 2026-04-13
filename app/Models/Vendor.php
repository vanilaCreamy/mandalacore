<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'address',
        'bank_name',
        'bank_account_number',
        'is_active',
        'note',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'materials_vendors', 'vendor_id', 'material_id');
    }

    
}
