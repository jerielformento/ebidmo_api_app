<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customers extends Authenticatable
{
    use HasApiTokens, HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'role',
        'auth_type',
        'is_verified',
        'verification_token',
        'remember_token',
        'registered_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
        'verification_token',
        'remember_token',
        'role',
        'auth_type'
    ];
 
    public function profile()
    {
        return $this->hasOne(CustomersProfile::class, 'customer_id');
    }

    public function store()
    {
        return $this->hasOne(Stores::class, 'customer_id');
    }

    public function bid()
    {
        return $this->hasMany(CustomerBids::class);
    }
}
