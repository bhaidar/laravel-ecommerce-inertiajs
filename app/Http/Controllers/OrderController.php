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
        (ShippingAddress::query()
            ->whereBelongsTo(auth()->user()) // only address that belong to me, no stealing for others' address
            ->firstOrCreate($request->shipping))
            ?->user() // associate user to shipping address if user logged-in
            ->associate(auth()->user())
            ->save();

        dd($request->all());
    }
}
