<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'name',
        'slug',
        'verified'
    ];

    protected $hidden = ['id', 'customer_id'];

    public function products()
    {
        return $this->hasMany(Products::class, 'store_id', 'id');
    }

    public function customer()
    {
        $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
}
