<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'price','serial_number'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
