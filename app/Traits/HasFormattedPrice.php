<?php

namespace App\Traits;

use App\Casts\MoneyAttribute;

trait HasFormattedPrice
{
    abstract protected function getMoneyAttribute(): string;

    public function initializeHasFormattedPrice(): void
    {
        // Append the accessor
        $this->append($this->getMoneyAttribute());

        // Add an accessor dynamically
        $this->casts = array_merge($this->casts, [
            $this->getMoneyAttribute() => MoneyAttribute::class,
        ]);
    }
}