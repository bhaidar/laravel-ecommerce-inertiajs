<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfCartEmpty;
use App\Http\Resources\ShippingAddressResource;
use App\Http\Resources\ShippingTypeResource;
use App\Models\ShippingType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfCartEmpty::class);
    }

    public function __invoke(Request $request): Response
    {
        return Inertia::render('Checkout',[
            'shippingTypes' => ShippingTypeResource::collection(ShippingType::orderBy('price', 'asc')->get()),
            'shippingAddresses' => ShippingAddressResource::collection(auth()->user()->shippingAddresses ?? []),
        ]);
    }
}
