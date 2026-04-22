<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'budget_plan_id',
        'menu_id',
        'date',
        'grand_total',
        'status',
    ];

    public function budgetPlan()
    {
        return $this->belongsTo(BudgetPlan::class, 'budget_plan_id', 'id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
