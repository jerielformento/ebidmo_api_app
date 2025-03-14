<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'acknowledgement_token',
        'checkout_id',
        'payment_id',
        'payment_method_used',
        'amount',
        'currency',
        'status'
    ];

    protected $hidden = [
        'id',
        'payment_id',
        'checkout_id',
        'acknowledgement_token',
        'updated_at'
    ];

    public function acknowledgement()
    {
        return $this->belongsTo(AuctionWinnerAcknowledgement::class, 'url_token');
    }
}
