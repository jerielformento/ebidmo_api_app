<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
        'category',
        'brand',
        'currency',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['id','store_id','updated_at','price','quantity'];

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
        return $this->hasOne(Auctions::class, 'product_id', 'id')->where('status', 1)->orWhere('status', 2);
    }

    public function auctions()
    {
        return $this->hasOne(Auctions::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrands::class, 'brand', 'id');
    }

    public function condition()
    {
        return $this->belongsTo(ProductConditions::class, 'condition', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currencies::class, 'currency', 'id');
    }

}
