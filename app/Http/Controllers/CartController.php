<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Cart\Exceptions\QuantityNoLongerAvailableException;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function __invoke(CartInterface $cart): Response
    {
        try {
            $cart->verifyAvailableQuantities();
        }
        catch (QuantityNoLongerAvailableException $exception)
        {
            $cart->syncAvailableQuantities();
        }

        return Inertia::render('Cart/Index');
    }
}
