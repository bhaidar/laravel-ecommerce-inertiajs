<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class OrderConfirmationIndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Order $order
     * @return Response
     */
    public function __invoke(Order $order): Response
    {
        return Inertia::render('Order/Confirmation', compact('order'));
    }
}
