<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Http\Requests\StoreCartVariationRequest;
use App\Models\Variation;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class CartVariationController extends Controller
{
    public function store(CartInterface $cart, StoreCartVariationRequest $request): RedirectResponse
    {
        try {
            // Validate request
            $request->validated();

            // Retrieve the Variation
            $variation = Variation::query()->findOrFail(Request::input('variation'));

            // Add the Variation
            $cart->add($variation, Request::input('quantity', 1));

            // Prepare a success notification message
            $request->success();
        }
        catch (Exception $ex)
        {
            Log::error($ex->getMessage());
        }

        return redirect()->back()->withNotification($request->notification);
    }
}
