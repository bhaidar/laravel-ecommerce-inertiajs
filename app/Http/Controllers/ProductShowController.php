<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class ProductShowController extends Controller
{
    public function __invoke(Product $product): \Inertia\Response
    {
        return Inertia::render('Products/Show', [
            'product' => $product->load('variations.childrenRecursive')
        ]);
    }
}
