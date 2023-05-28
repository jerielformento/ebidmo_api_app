<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->hasOne(Stores::class, 'id', 'store_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }

    public function thumbnail()
    {
        return $this->hasOne(ProductImages::class, 'product_id', 'id');
    }

    public function bid()
    {
        return $this->hasOne(Bids::class, 'product_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrands::class, 'brand', 'id');
    }

    public function condition()
    {
        return $this->belongsTo(ProductConditions::class, 'condition', 'id');
    }
}
