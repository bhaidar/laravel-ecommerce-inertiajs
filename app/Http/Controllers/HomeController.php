<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;

class HomeController extends Controller
{
    public function __invoke(): \Inertia\Response
    {
        return Inertia::render('Welcome', [
            'categories' => Category::query()->tree()->get(['id', 'title', 'slug', 'parent_id'])->toTree(),
        ]);
    }
}
