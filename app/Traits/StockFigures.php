<?php

namespace App\Traits;

class StockFigures
{
    public int $stockCount = 0;
    public bool $inStock = false;
    public bool $outOfStock = false;
    public bool $lowStock = false;

    public static function make(): StockFigures
    {
        return new self();
    }
}