<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use Inertia\Inertia;
use App\Models\Category;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Welcome', [
            'categories' => CategoryResource::collection(Category::tree()->get()->toTree()),
        ]);
    }
}
