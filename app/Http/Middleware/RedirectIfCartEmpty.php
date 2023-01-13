<?php

namespace App\Http\Middleware;

use App\Cart\Contracts\CartInterface;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RedirectIfCartEmpty
{
    public function __construct(protected CartInterface $cart) {}

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse|Response|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->cart->isEmpty()) {
            return to_route('cart.index');
        }
        return $next($request);
    }
}
