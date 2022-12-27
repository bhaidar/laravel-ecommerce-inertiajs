<?php

namespace App\Http\Controllers;

use App\Actions\Search;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function __invoke(Search $search, Request $request): Response
    {
        return Inertia::render('Products/SearchResults',[
            'products' => ProductResource::collection($search->execute($request)),
        ]);
    }
}