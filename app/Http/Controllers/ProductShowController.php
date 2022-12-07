<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variation;
use Inertia\Inertia;

class ProductShowController extends Controller
{
    public function __invoke(Product $product): \Inertia\Response
    {
        $product->setRelation(
            'variations',
            Variation::with('stocks')->treeOf(fn($query) => $query->isRoot()->where('product_id', $product->id))->get()->toTree()
        );

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }
}