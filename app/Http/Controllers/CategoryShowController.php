<?php

namespace App\Http\Controllers;

use App\Actions\ShowCategory;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;

class CategoryShowController extends Controller
{
    public function __invoke(ShowCategory $showCategory, Category $category): Response
    {
        return Inertia::render('Categories/Show', [
            'category' => $showCategory->execute($category)->toResource(),
        ]);
    }
}
