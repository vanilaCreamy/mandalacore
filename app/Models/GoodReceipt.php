<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodReceipt extends Model
{
    protected $table = 'goods_receipts';

    protected $fillable = [
        'receipt_number',
        'po_id',
        'vendor_id',
        'receipt_date',
        'note',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(GoodReceiptItem::class, 'receipt_id', 'id');
    }
}
