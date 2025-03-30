<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [ 'supplier_id','purchase_date', 'invoice_number', 'status','total_cost', 'total_qty' ];

    protected static function booted()
{
    static::updated(function (Purchase $purchase) {
        if ($purchase->status === 'delivered' && $purchase->product) {
            foreach ($purchase->product as $product) {
                Inventory::create([
                    'product_id' => $product->product_id,
                    'serial_number' => $product->serial_number,
                    'quantity' => $product->quantity,
                    'status' => 'available',
                ]);
            }
        }
    });
}

    public function product()
    {
        return $this->hasMany(PurchaseProduct::class);
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }



}
