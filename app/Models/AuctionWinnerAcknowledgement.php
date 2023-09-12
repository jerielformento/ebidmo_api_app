<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionWinnerAcknowledgement extends Model
{
    use HasFactory;
    protected $table = 'auction_winner_acknowledgement';
    public $timestamps = false;
    protected $fillable = [
        'auction_id',
        'customer_id',
        'url_token',
        'status',
        'started_at',
        'ended_at'
    ];

    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    public function auction()
    {
        return $this->hasOne(Auctions::class, 'id', 'auction_id');
    }
}
