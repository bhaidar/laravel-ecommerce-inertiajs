<?php

namespace App\Models;

use App\Traits\HasFormattedPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingType extends Model
{
    use HasFactory;
    use HasFormattedPrice;

    protected $fillable = [
        'title',
        'price',
    ];

    protected function getMoneyAttribute(): string
    {
        return 'price';
    }

}
