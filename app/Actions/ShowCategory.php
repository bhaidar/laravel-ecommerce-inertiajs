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

        list('products' => $products, 'filters' => $filters) = $this->loadProducts($request, $category);

        return compact('category', 'products', 'filters');
    }

    private function loadProducts(Request $request, Category $category)
    {
        $search = Product::search(
            query: trim($request->get('search')) ?? '',
            callback: function (Indexes $meilisearch, string $query, array $options) use ($category) {
                $options['filter'] = 'category_ids = ' . $category->id;
                $options['facets'] = ['size', 'color'];

                return $meilisearch->search($query, $options);
            },
        )->raw(); // coming from meilisearch

        // Load eloquent models
        $products = $category
            ->products()
            ->with('media')
            ->find(collect($search['hits'])->pluck('id'));

        // prepare media urls
        $this->loadMedia($products);

        return [
            'products' => $products,
            'filters' => $search['facetDistribution'],
        ];
    }

    private function loadMedia(Collection $products): void
    {
        $products->each->getMediaUrls();
    }
}