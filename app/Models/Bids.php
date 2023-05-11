<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'min_price',
        'buy_now_price',
        'currency',
        'started_at',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function bidders()
    {
        return $this->hasMany(CustomerBids::class, 'bid_id');
    }
}
