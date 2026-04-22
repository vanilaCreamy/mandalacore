<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    protected $table = 'budget_plans';
    
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'budget',
    ]; 

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'budget_plan_id', 'id');
    }

    public function getTotalUsedAttribute(): int
    {
        return (int) $this->purchaseOrders()->sum('grand_total');
    }

    public function getRemainingBudgetAttribute(): int
    {
        return (int) ($this->budget - $this->total_used);
    }

    public function getPoCountAttribute(): int
    {
        return (int) $this->purchaseOrders()->count();
    }

}
