<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionParticipants extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'auction_id',
        'customer_id'
    ];

    public function bid()
    {
        $this->belongsTo(Bids::class);
    }
}
