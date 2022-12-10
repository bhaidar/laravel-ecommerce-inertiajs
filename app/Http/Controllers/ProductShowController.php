<?php

namespace App\Http\Controllers;

use App\Actions\ShowProduct;
use App\Cart\Contracts\CartInterface;
use App\Models\Product;
use App\Models\Variation;
use Inertia\Inertia;

class ProductShowController extends Controller
{
    public function __invoke(CartInterface $cart, ShowProduct $showProduct, Product $product): \Inertia\Response
    {
        return Inertia::render('Products/Show', [
            'product' => $showProduct->execute($product),
        ]);
    }
}