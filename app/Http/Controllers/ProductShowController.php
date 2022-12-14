<?php

namespace App\Http\Controllers;

use App\Actions\ShowProduct;
use App\Cart\Contracts\CartInterface;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductShowController extends Controller
{
    public function __invoke(CartInterface $cart, ShowProduct $showProduct, Product $product): Response
    {
        return Inertia::render('Products/Show', [
            'product' => $showProduct->execute($product),
        ]);
    }
}