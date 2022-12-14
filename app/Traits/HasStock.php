<?php

namespace App\Traits;

use App\Models\Variation;

trait HasStock
{
    public function getStock (Variation $variation): int
    {
        $stockFigures = StockFigures::make();

        if (!empty($variation->stocks))
        {
            $stockFigures->stockCount = $this->calculateSelfStock($variation);

            $this->calculateStockState($stockFigures);
            $variation['stockFigures'] = $stockFigures;
        }

        if (!empty($variation->children)) {
            foreach ($variation->children as $childVariation)
            {
                $stockFigures->stockCount += $this->getStock($childVariation);

                $this->calculateStockState($stockFigures);
                $variation['stockFigures'] = $stockFigures;
            }
        }

        return $stockFigures->stockCount;
    }

    private function calculateSelfStock(Variation $variation): int
    {
        return array_reduce($variation->stocks->toArray(), function ($carry, $item) {
            return $carry + $item['amount'];
        }, 0);
    }

    private function minStock(): int
    {
        return intVal(config('services.shop.lowStock'));
    }

    private function calculateStockState($stockFigures): void
    {
        $stockFigures->inStock = $stockFigures->stockCount > 0;
        $stockFigures->outOfStock = $stockFigures->stockCount  <= 0;
        $stockFigures->lowStock = !$stockFigures->outOfStock && $stockFigures->stockCount < $this->minStock();
    }
}