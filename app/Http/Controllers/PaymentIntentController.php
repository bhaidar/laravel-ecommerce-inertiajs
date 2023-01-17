<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Http\Requests\PaymentIntentRequest;
use App\Http\Resources\PaymentIntentResource;
use Illuminate\Http\Request;

class PaymentIntentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param PaymentIntentRequest $request
     * @param CartInterface $cart
     * @return PaymentIntentResource
     */
    public function __invoke(PaymentIntentRequest $request, CartInterface $cart): PaymentIntentResource
    {
        if (!$cart->hasPaymentIntent()) {
            $paymentIntent = app('stripe')->paymentIntents->create([
                'amount' => (int)$request->total, // cents
                'currency' => config('money.defaultCurrency'),
                'setup_future_usage' => 'on_session', // on-time payment
                'metadata' => [
                    'user_id' => $request->user()?->id, // can be used later in Webhooks
                ],
                'payment_method_types' => ['card'],
            ]);

            // store payment intent id on cart
            $cart->updatePaymentIntentId($paymentIntent->id);
        } else {
            $paymentIntent = app('stripe')->paymentIntents->retrieve($cart->getPaymentIntentId());

            // update only pending payment intent
            if ($paymentIntent->status !== 'succeeded') {
                app('stripe')->paymentIntents->update($cart->getPaymentIntentId(), [
                    'amount' => (int)$request->total,
                ]);
            }
        }

        return PaymentIntentResource::make($paymentIntent);
    }
}