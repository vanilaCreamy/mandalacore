<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPortion extends Model
{
    protected $fillable = [
        'menu_id',
        'portion_base_id',
        'total_portions',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function portion_base()
    {
        return $this->belongsTo(PortionBase::class, 'portion_base_id', 'id');
    }
}
