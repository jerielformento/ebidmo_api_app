<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CustomerBids extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'customer_bids';
    protected $fillable = [
        'auction_id',
        'customer_id',
        'price',
        'bidded_at'
    ];

    protected $hidden = ['id','customer_id'];

    public function bid()
    {
        $this->belongsTo(Auctions::class);
    }

    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }
}
