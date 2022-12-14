<?php

namespace App\Traits;

class StockFigures
{
    public function __construct(
        public int $stockCount,
        public bool $inStock,
        public bool $outOfStock,
        public bool $lowStock
    )
    {
    }

    public static function make(
        int $stockCount = 0,
        bool $inStock = false,
        bool $outOfStock = false,
        bool $lowStock = false
    ): StockFigures
    {
        return new self($stockCount, $inStock, $outOfStock, $lowStock);
    }
}