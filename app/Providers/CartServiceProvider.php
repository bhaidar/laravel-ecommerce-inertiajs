<?php

namespace App\Providers;

use App\Actions\GetCart;
use App\Cart\Cart;
use App\Cart\Contracts\CartInterface;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // App/Cart/Cart.php
        $this->app->singleton(CartInterface::class, fn () => new Cart(session(), $this->app->make(GetCart::class)));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
