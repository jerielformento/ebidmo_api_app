<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class CustomersProfile extends Model
{
    use HasApiTokens, HasFactory;

    public $timestamps = false;
    protected $table = 'customers_profile';
    protected $fillable = [
        'customer_id',
        'email',
        'first_name',
        'last_name',
        'middle_name',
        'phone'
    ];
}
