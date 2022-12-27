<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class Search
{
    public function execute(Request $request): Collection
    {
        return Product::search(trim($request->get('search')) ?? '')->get();
    }
}