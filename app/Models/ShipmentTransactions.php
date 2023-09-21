<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentTransactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'acknowledgement_token',
        'full_name',
        'address',
        'contact',
        'courier',
        'status'
    ];

    protected $hidden = [
        'id'
    ];

    public function courier()
    {
        return $this->belongsTo(Couriers::class, 'courier', 'id');
    }

    public function acknowledgement()
    {
        return $this->belongsTo(AuctionWinnerAcknowledgement::class, 'url_token');
    }
}
