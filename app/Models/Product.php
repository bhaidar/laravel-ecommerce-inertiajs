<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = [
        'formatted_price',
    ];

    /**
     * Get the formatted price.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => money($this->price),
        );
    }
}
