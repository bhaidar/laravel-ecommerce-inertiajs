<?php

namespace App\Http\Controllers;

use App\Actions\GetOrderVariations;
use App\Http\Resources\OrderResource;
use Inertia\Response;

class OrderIndexController extends Controller
{
    public function __invoke(GetOrderVariations $getOrderVariations): Response
    {
        return inertia()->render('Orders/Index', [
            'orders' => OrderResource::collection($getOrderVariations->execute(auth()->user())),
        ]);
    }
}
