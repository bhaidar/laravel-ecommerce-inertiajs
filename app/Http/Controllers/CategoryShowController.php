<?php

namespace App\Http\Controllers;

use App\Actions\ShowCategory;
use App\Http\Resources\ProductResource;
use App\Models\Category;
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
        $result = $showCategory->execute($request, $category);

        return Inertia::render('Categories/Show', [
            'category' => $result['category']->toResource(),
            'products' => ProductResource::collection($result['products']),
        ]);
    }
}
