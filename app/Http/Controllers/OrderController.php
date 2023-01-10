<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreOrderRequest $request)
    {
        dd($request);
    }
}
