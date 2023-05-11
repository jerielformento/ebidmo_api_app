<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'details',
        'condition',
        'brand',
        'quantity',
        'created_at'
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }

    public function bid()
    {
        return $this->hasOne(Bids::class, 'product_id');
    }
}
