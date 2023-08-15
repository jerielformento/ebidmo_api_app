<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Auctions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'min_price',
        'min_participants',
        'buy_now_price',
        'currency',
        'started_at',
        'ended_at',
        'increment_by',
        'status'
    ];

    protected $hidden = ['product_id', 'won_by'];

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function products()
    {
        return $this->belongsTo(Products::class);
    }

    public function bidders()
    {
        return $this->hasMany(CustomerBids::class, 'auction_id');
    }

    public function highest()
    {
        return $this->hasOne(CustomerBids::class, 'auction_id', 'id')->ofMany('price','max');
    }

    public function currency()
    {
        return $this->hasOne(Currencies::class, 'id', 'currency');
    }

    public function participants()
    {
        return $this->hasMany(AuctionParticipants::class, 'auction_id', 'id');
    }

    public function winner()
    {
        return $this->hasOne(Customers::class, 'id', 'won_by');
    }
}
