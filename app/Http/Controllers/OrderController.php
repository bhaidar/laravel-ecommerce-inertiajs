<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\ShippingAddress;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreOrderRequest $request)
    {
        // Create shipping address
        ShippingAddress::firstOrCreate($request->shipping);

        dd($request->all());
    }
}
