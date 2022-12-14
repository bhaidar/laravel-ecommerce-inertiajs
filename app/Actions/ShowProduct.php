<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Variation;

class ShowProduct
{
    public function execute(Product $product): Product
    {
        // load product variations Tree
        // I decided to load the tree of variations here rather than inside the model
        // so that I could control better when to load them in this format
        $this->loadVariationTree($product);

        // load product's variations stock
        $product->loadStock();

        // prepare media urls
        $this->loadMedia($product);

        return $product;
    }

    private function loadVariationTree(Product $product): void
    {
        $product->setRelation(
            'variations',
            Variation::with(['stocks'])
                ->treeOf(fn($query) => $query->isRoot()->where('product_id', $product->id))
                ->get()
                ->toTree()
        );
    }

    private function loadMedia($product): void
    {
        // Load relationship
        // This way, we can load media to multiple product at once when needed
        $product->load('media');

        // Do in-memory image generation
        $product->getMediaUrls();
    }
}