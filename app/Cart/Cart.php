<?php

namespace App\Cart;

use App\Cart\Contracts\CartInterface;
use Illuminate\Session\SessionManager;
use JetBrains\PhpStorm\NoReturn;

class Cart implements CartInterface
{
    public function __construct(protected SessionManager $session)
    {
    }

    #[NoReturn] public function create()
    {
        dd($this->session);
    }
}