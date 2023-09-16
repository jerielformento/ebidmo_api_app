<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransactions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'payment_id',
        'payment_request_id',
        'phone',
        'amount',
        'currency',
        'status',
        'reference_number',
        'hmac'
    ];
}
