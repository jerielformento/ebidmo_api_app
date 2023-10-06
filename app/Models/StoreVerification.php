<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVerification extends Model
{
    use HasFactory;
    protected $table = 'store_verification';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'social_store_link',
        'ownership_proof_image'
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }
}
