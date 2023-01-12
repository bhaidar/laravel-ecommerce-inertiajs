<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Cart\Exceptions\QuantityNoLongerAvailableException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function __invoke(CartInterface $cart): Response
    {
        try {
            $cart->verifyAvailableQuantities();
        } catch (QuantityNoLongerAvailableException) {
            session()->now('notification', [
                'title' => 'Some items or quantities in your cart have become unavailable.',
                'color' => 'gray',
            ]);

            $cart->syncAvailableQuantities();
        }

        return Inertia::render('Cart/Index');
    }
}
