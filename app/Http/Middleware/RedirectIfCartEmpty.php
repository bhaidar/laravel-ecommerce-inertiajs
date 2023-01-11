<?php

namespace App\Http\Middleware;

use App\Cart\Contracts\CartInterface;
use Closure;
use Illuminate\Http\Request;

class RedirectIfCartEmpty
{
    public function __construct(protected CartInterface $cart) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->cart->isEmpty()) {
            return to_route('cart.index');
        }
        return $next($request);
    }
}
