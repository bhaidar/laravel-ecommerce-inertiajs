<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variation;
use Inertia\Inertia;

class ProductShowController extends Controller
{
    public function __invoke(Product $product): \Inertia\Response
    {
        // set dynamic relation
        $product->setRelation(
            'variations',
            Variation::with(['stocks'])->treeOf(fn($query) => $query->isRoot()->where('product_id', $product->id))->get()->toTree()
        );

        // calculate stock at each level
        $product = $this->calculateStock($product);

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    private function calculateStock(\App\Models\Product $product): \App\Models\Product
    {
        if (!empty($product->variations))
        {
            foreach ($product->variations as $variation)
            {
                $variation['stock_count'] = $this->stockCount($variation);
                $product['stock_count'] += $variation['stock_count'];
            }
        }

        return $product;
    }

    private function stockCount (Variation $variation): int
    {
        if (!empty($variation->stocks)) {
            $variation['stock_count'] = array_reduce($variation->stocks->toArray(), function ($carry, $item) {
                return $carry + $item['amount'];
            }, 0);
        }

        if (!empty($variation->children)) {
            foreach ($variation->children as $childVariation)
            {
                $variation['stock_count'] += $this->stockCount($childVariation);
            }
        }

        return $variation['stock_count'];
    }
}