<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'redirect_url',
        'thumbnail_url'
    ];

    protected $hidden = [
        //'id'
    ];

}
