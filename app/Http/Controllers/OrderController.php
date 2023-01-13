<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\Variation;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     * @param StoreOrderRequest $request
     */
    public function __invoke(StoreOrderRequest $request, CartInterface $cart)
    {
        // Create shipping address
        $shippingAddress = (ShippingAddress::query()
            ->when(auth()->user(), fn($query) => $query->whereBelongsTo(auth()->user()))
            ->firstOrCreate($request->shipping))
            ?->user() // associate user to shipping address if user logged-in
            ->associate(auth()->user());
        $shippingAddress->save();

        // Create order
        $order = Order::make([
            'email' => $request->email ?? auth()->user()->email,
            'subtotal' => $cart->subTotal()->getAmount(),
        ])
            ->user()->associate(auth()->user())
            ->shippingAddress()->associate($shippingAddress)
            ->shippingType()->associate($request->shippingType);
        $order->save();

        // Link Order to variations
        $order->variations()->attach(
          $cart->items()->mapWithKeys(function (Variation $variation) {
              return [
                  $variation->id => [
                      'quantity' => $variation->pivot->quantity,
                  ],
              ];
          })
        );

        return back();
    }
}
