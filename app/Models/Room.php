<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'Location'];

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function getNameLocationAttribute()
    {
        return "{$this->name}, {$this->Location}";
    }
}
