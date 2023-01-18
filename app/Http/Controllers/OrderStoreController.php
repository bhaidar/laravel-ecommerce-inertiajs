<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Http\Requests\StoreOrderRequest;
use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\Variation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class OrderStoreController extends Controller
{
    /**
     * Handle the incoming request.
     * @param StoreOrderRequest $request
     * @param CartInterface $cart
     * @return RedirectResponse
     */
    public function __invoke(StoreOrderRequest $request, CartInterface $cart): RedirectResponse
    {
        $paymentIntent = app('stripe')->paymentIntents->retrieve($cart->getPaymentIntentId());
        if ($paymentIntent->status !== 'succeeded') {
            return back()->with('notification', [
                'message' => 'Order is not successful!',
            ]);
        }

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

        // Link Orders to variations
        $order->variations()->attach(
            $cart->items()->mapWithKeys(function (Variation $variation) {
                return [
                    $variation->id => [
                        'quantity' => $variation->pivot->quantity,
                    ],
                ];
            })->toArray(),
        );

        // Reduce the stock
        $cart->items()->each(function (Variation $variation) {
            $variation->stocks()->create([
                'amount' => 0 - $variation->pivot->quantity,
            ]);
        });

        // Send email order created
        Mail::to($order->user)->send(new OrderCreated($order));

        // Clear cart
        $cart->removeAll();

        // Delete cart
        $cart->destroy();

        if (!auth()->user())
        {
            // Redirect to confirmation page
            return to_route('orders.confirmation', $order);
        }

        // User signed-in
        // Redirect to orders page
        return to_route('orders.index');
    }
}
