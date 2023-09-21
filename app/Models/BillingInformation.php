<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'address',
        'full_name',
        'mobile_number'
    ];

    protected $hidden = [
        'id',
        'customer_id'
    ];

    public function acknowledgement()
    {
        return $this->belongsTo(AuctionWinnerAcknowledgement::class, 'customer_id');
    }
}
