<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Meilisearch\Endpoints\Indexes;
use Illuminate\Http\Request;

class ShowCategory
{
    public function execute(Request $request, Category $category): array
    {
        $category->load(['ancestors', 'children']);

        $products = Product::search(
            query: trim($request->get('search')) ?? '',
            callback: function (Indexes $meilisearch, string $query, array $options) use ($category) {
                $options['filter'] = 'category_ids = ' . $category->id;

                return $meilisearch->search($query, $options);
            },
        )->get();

        // prepare media urls
        $this->loadMedia($products);

        return compact('category', 'products');
    }

    private function loadMedia(Collection $products): void
    {
        $products->load('media');
        $products->each->getMediaUrls();
    }

    private function preloadProductsOnVariation($product): void
    {
        $product->variations->each->setRelation('product', $product);
    }
}