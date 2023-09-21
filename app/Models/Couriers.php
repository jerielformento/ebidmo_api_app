<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couriers extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function shipment()
    {
        return $this->hasOne(ShipmentTransactions::class, 'courier', 'id');
    }
}
