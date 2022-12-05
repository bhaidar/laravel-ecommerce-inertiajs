<?php

namespace App\Console\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasFormattedPrice
{
    public function initializeHasFormattedPrice(): void
    {
        // Not needed because price already exists,
        // I am keeping it for reference
        // $this->append('price');
    }

    /**
     * Get the formatted price.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => money($value),
        );
    }
}