<?php

namespace App\Http\Controllers;

use App\Actions\ShowCategory;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FilterResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class CategoryShowController extends Controller
{
    public function __invoke(
        Request $request,
        ShowCategory $showCategory,
        Category $category,
    ): Response
    {
        $search = $showCategory->execute($request, $category);

        return Inertia::render('Categories/Show', [
            'category' => new CategoryResource($search['category']),
            'products' => ProductResource::collection($search['products']),
            'filters' => new FilterResource($search['filters']),
            'maxPrice' => $search['maxPrice'],
        ]);
    }
}
