<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'title'
    ];

    public function product()
    {
        return $this->hasOne(Products::class, 'category', 'id');
    }
}
