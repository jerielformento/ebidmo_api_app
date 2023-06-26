<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidParticipants extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'bid_id',
        'customer_id'
    ];

    public function bid()
    {
        $this->belongsTo(Bids::class);
    }
}
