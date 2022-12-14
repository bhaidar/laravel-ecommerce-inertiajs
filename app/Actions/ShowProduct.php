<?php

namespace App\Actions;

use App\Models\Product;

class ShowProduct
{
    public function execute(Product $product): Product
    {
        // load product's variations stock
        $product->loadStock();

        // prepare media urls
        $product->loadImages();

        return $product;
    }
}