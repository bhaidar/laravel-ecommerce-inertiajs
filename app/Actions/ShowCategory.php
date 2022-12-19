<?php

namespace App\Actions;

use App\Models\Category;

class ShowCategory
{
    public function execute(Category $category): Category
    {
        $category->load('ancestors');

        // prepare media urls
        $this->loadMedia($category);

        return $category;
    }

    private function loadMedia(Category $category): void
    {
        // Load media for all products using one query
        $category->load('products.media');

        // Prepare the product media
        $category->products->each->getMediaUrls();
    }

    private function preloadProductsOnVariation($product): void
    {
        $product->variations->each->setRelation('product', $product);
    }
}