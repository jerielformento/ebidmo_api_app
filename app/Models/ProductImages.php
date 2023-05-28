<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'filename',
        'url',
        'mime_type',
        'size'
    ];

    public function product()
    {
        $this->belongsTo(Products::class, 'id', 'product_id');
    }
}
