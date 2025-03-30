<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'serial_number', 'quantity', 'status' ];

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


}
