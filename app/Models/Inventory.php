<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'product_id',
                            'purchase_id',
                            'purchase_pruduct_id',
                            'locate_id', 
                            'serial_number', 
                            'quantity', 
                            'user', 
                            'status',
                            'remark',
                            'unit_price', 
                            'code', 
                            'asset_identity_no', 
                            'class_of_asset']; 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function loans()
    {
        return $this->hasOne(Loan::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function purchaseProduct()
    {
        return $this->belongsTo(PurchaseProduct::class);
    }

    public function locate()
    {
        return $this->belongsTo(Locate::class);
    }

}
