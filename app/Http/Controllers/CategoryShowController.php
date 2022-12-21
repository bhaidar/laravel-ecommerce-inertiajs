<?php

namespace App\Http\Controllers;

use App\Actions\ShowCategory;
use App\Http\Resources\FilterResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use stdClass;

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
            'category' => $search['category']->toResource(),
            'products' => ProductResource::collection($search['products']),
            'filters' => new FilterResource($search['filters']),
        ]);
    }
}
