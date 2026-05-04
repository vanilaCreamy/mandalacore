<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodReceiptItem extends Model
{
    protected $table = 'goods_receipt_items';

    protected $fillable = [
        'receipt_id',
        'vendor_id',
        'material_id',
        'qty_ordered',
        'qty_received',
        'price',
        'subtotal'
    ];

    public function receipt()
    {
        return $this->belongsTo(GoodReceipt::class, 'receipt_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
