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

    public function payment()
    {
        return $this->hasOne(PaymentTransactions::class, 'acknowledgement_token', 'url_token');
    }

    public function shipment()
    {
        return $this->hasOne(ShipmentTransactions::class, 'acknowledgement_token', 'url_token');
    }

    public function billing()
    {
        return $this->hasOne(BillingInformation::class, 'customer_id', 'customer_id');
    }
}
