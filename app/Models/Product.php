<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Product extends Model
{
    use HasFactory;
    use HasRecursiveRelationships;

    protected $appends = [
        'formatted_price',
    ];

    public function variations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Variation::class);
    }

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
