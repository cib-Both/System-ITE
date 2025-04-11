<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name','inventory_id', 'department_id', 'position','phone_number', 'loan_date','return_date', 'status'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    protected static function booted()
    {
        static::updated(function (Loan $loan) {
            if ($loan->status === 'active') {
                // Update inventory status to 'loaned'
                $loan->inventory->update(['status' => 'loaned']);
            } elseif ($loan->status === 'returned') {
                // Update inventory status to 'available'
                $loan->inventory->update(['status' => 'available']);
            }
        });

        static::created(function (Loan $loan) {
            // When a loan is created, set the inventory status to 'loaned'
            if ($loan->status === 'active') {
                $loan->inventory->update(['status' => 'loaned']);
            }
        });
    }
}
