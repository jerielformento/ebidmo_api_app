<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'code',
        'description'
    ];

    public function bid()
    {
        $this->belongsTo(Bids::class, 'currency', 'id');
    }
}
