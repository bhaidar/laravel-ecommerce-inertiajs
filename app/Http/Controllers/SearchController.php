<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function __invoke(Request $request): Response
    {


        return Inertia::render('Categories/Show', [
            'products' => $products,
        ]);
    }
}