<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use Inertia\Response;

class OrderIndexController extends Controller
{
    public function __invoke(): Response
    {
        return inertia()->render('Orders/Index', [
            'orders' => OrderResource::collection(auth()->user()->orders()->with(['shippingType', 'variations.ancestorsAndSelf'])->get()),
        ]);
    }
}
