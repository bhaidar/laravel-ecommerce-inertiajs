<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Variation;

class ShowProduct
{
    private const STOCK_COUNT = 'stockCount';
    private const IN_STOCK = 'inStock';
    private const OUT_OF_STOCK = 'outOfStock';
    private const LOW_STOCK = 'lowStock';
    private const CONFIG_MINIMUM_STOCK = 'services.shop.lowStock';

    public function execute(Product $product): Product
    {
        // set dynamic relation
        $product->setRelation(
            'variations',
            Variation::with(['stocks'])
                ->treeOf(fn($query) => $query->isRoot()->where('product_id', $product->id))
                ->get()
                ->toTree()
        );

        // calculate stock at each level & return product
        return $this->calculateStock($product);
    }

    private function calculateStock(Product $product): Product
    {
        if (!empty($product->variations))
        {
            foreach ($product->variations as $variation)
            {
                $variation[self::STOCK_COUNT] = $this->stockCount($variation);
                $product[self::STOCK_COUNT] += $variation[self::STOCK_COUNT];
            }

            $stockCount = intVal($product[self::STOCK_COUNT]);
            $product[self::IN_STOCK] =  $stockCount > 0;
            $product[self::OUT_OF_STOCK] = $stockCount <= 0;
            $product[self::LOW_STOCK] = !$product[self::OUT_OF_STOCK] && $stockCount < intVal(config(self::CONFIG_MINIMUM_STOCK));
        }

        return $product;
    }

    private function stockCount (Variation $variation): int
    {
        if (!empty($variation->stocks)) {
            $variation[self::STOCK_COUNT] = array_reduce($variation->stocks->toArray(), function ($carry, $item) {
                return $carry + $item['amount'];
            }, 0);
            $stockCount = intVal($variation[self::STOCK_COUNT]);
            $variation[self::IN_STOCK] =  $stockCount > 0;
            $variation[self::OUT_OF_STOCK] = $stockCount  <= 0;
            $variation[self::LOW_STOCK] = !$variation[self::OUT_OF_STOCK] && $stockCount < intVal(config(self::CONFIG_MINIMUM_STOCK));
        }

        if (!empty($variation->children)) {
            foreach ($variation->children as $childVariation)
            {
                $variation[self::STOCK_COUNT] += $this->stockCount($childVariation);
                $stockCount = intVal($variation[self::STOCK_COUNT]);

                $variation[self::IN_STOCK] = $stockCount > 0;
                $variation[self::OUT_OF_STOCK] = $stockCount <= 0;
                $variation[self::LOW_STOCK] = !$variation[self::OUT_OF_STOCK] && $stockCount < intVal(config(self::CONFIG_MINIMUM_STOCK));
            }
        }

        return $variation[self::STOCK_COUNT];
    }
}