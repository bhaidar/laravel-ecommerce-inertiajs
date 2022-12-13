<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Cart/Index');
    }
}
