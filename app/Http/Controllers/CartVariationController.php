<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Http\Requests\PatchCartVariationRequest;
use App\Http\Requests\StoreCartVariationRequest;
use App\Models\Variation;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class CartVariationController extends Controller
{
    /**
     * @param CartInterface $cart
     * @param StoreCartVariationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCartVariationRequest $request, CartInterface $cart): RedirectResponse
    {
        try {
            // Retrieve the Variation
            $variation = Variation::query()->findOrFail($request->variation);

            // Add the Variation
            $cart->add($variation, $request->get('quantity', 1));

            // Prepare a success notification message
            $request->success($variation);
        }
        catch (Exception $ex)
        {
            Log::error($ex->getMessage());
        }

        return redirect()->back()->withNotification($request->notification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CartInterface $cart
     * @param PatchCartVariationRequest $request
     * @param Variation $variation
     * @return RedirectResponse
     */
    public function update(PatchCartVariationRequest $request, Variation $variation, CartInterface $cart): RedirectResponse
    {
        // Change the variation quantity
        $cart->changeQuantity($variation, $request->get('quantity', 1);

        // Prepare a success notification message
        $request->success();

        return redirect()->back()->withNotification($request->notification);
    }

    /**
     * @param Variation $variation
     * @return RedirectResponse
     */
    public function destroy(CartInterface $cart, Variation $variation): RedirectResponse
    {
        $cart->remove($variation);

        $notification = [
            'title' => "Item removed",
            'message' => 'Your item was successfully removed!',
            'color' => 'green',
        ];

        return redirect()->back()->withNotification($notification);
    }
}
