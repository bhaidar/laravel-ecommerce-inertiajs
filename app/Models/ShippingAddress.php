<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'city',
        'postcode',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
