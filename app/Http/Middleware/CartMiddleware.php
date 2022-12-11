<?php

namespace App\Http\Middleware;

use App\Cart\Contracts\CartInterface;
use Closure;
use Illuminate\Http\Request;

class CartMiddleware
{
    public function __construct(protected CartInterface $cart)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$this->cart->exists())
        {
            $this->cart->create($request->user());
        }

        return $next($request);
    }
}
