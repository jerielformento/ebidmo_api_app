<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBids extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'customer_bids';
    protected $fillable = [
        'bid_id',
        'customer_id',
        'price',
        'bidded_at'
    ];

    public function bid()
    {
        $this->belongsTo(Bids::class);
    }
}
