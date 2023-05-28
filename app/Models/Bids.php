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
        'ended_at',
        'increment_by',
        'status'
    ];

    public function product()
    {
        return $this->hasOne(Products::class, 'product_id', 'id');
    }

    public function bidders()
    {
        return $this->hasMany(CustomerBids::class, 'bid_id');
    }

    public function highest()
    {
        return $this->hasOne(CustomerBids::class, 'bid_id', 'id')->ofMany('price','max');
    }

    public function currency()
    {
        return $this->hasOne(Currencies::class, 'id', 'currency');
    }
}
