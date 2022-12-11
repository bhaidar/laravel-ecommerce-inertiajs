<?php

namespace App\Cart;

use App\Cart\Contracts\CartInterface;
use App\Models\User;
use Illuminate\Session\SessionManager;
use App\Models\Cart as ModelsCart;

class Cart implements CartInterface
{
    // Caching in-class cart instance
    protected ModelsCart $instance;

    public function __construct(protected SessionManager $session)
    {
    }

    public function exists()
    {
        return $this->session->has(config('cart.session.key'));
    }

    public function create(?User $user = null)
    {
        $instance = ModelsCart::query()->make();

        if ($user)
        {
            $instance->user()->associate($user);
        }

        $instance->save();

        $this->session->put(config('cart.session.key'), $instance->uuid);
    }

    public function contents()
    {
        return $this->instance()->variations;
    }

    protected function instance()
    {
        if (!isset($this->instance)) {
            $this->instance = ModelsCart::whereUuid($this->session->get(config('cart.session.key')))->firstOrFail();
        }

        return $this->instance;
    }
}