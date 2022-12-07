<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variation;
use Inertia\Inertia;

class ProductShowController extends Controller
{
    public function __invoke(Product $product): \Inertia\Response
    {
        return Inertia::render('Products/Show', [
            'product' => $product->load(['variations.stocks', 'variations.variations.stocks']),
        ]);
    }
}