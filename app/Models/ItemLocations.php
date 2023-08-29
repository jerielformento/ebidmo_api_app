<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLocations extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'country'
    ];

    public function product()
    {
        return $this->hasOne(Products::class, 'item_location', 'id');
    }
}
