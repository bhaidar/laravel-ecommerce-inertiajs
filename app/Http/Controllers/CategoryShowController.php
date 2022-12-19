<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;

class CategoryShowController extends Controller
{
    public function __invoke(Category $category): Response
    {
        // load the ancestors
        $category->load(['ancestors', 'products']);

        return Inertia::render('Categories/Show', [
            'category' => $category->toResource(),
        ]);
    }
}
