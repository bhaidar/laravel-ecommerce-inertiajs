<?php

namespace App\Cart;

use App\Actions\GetCart;
use App\Cart\Contracts\CartInterface;
use App\Cart\Exceptions\QuantityNoLongerAvailableException;
use App\Http\Resources\CartResource;
use App\Models\User;
use App\Models\Variation;
use Cknow\Money\Money;
use Exception;
use Illuminate\Session\SessionManager;
use App\Models\Cart as ModelsCart;

class Cart implements CartInterface
{
    // Caching in-class cart instance
    protected ?ModelsCart $instance;

    public function __construct(
        protected SessionManager $session,
        protected GetCart $getCart,
    )
    { }

    public function add($variation, int $quantity = 1)
    {
        // Increment quantity when a variation already exists in the cart
        if ($existingVariation = $this->getVariation($variation)) {
            $quantity += $existingVariation->pivot->quantity;
        }

        $this->instance()->variations()->sync(
            ids: [
                $variation->id => [
                    // Allow adding the max in stock
                    'quantity' => min($quantity, $variation->stockCount()),
                ],
            ],
            detaching: false
        );
    }

    public function changeQuantity(Variation $variation, int $quantity)
    {
        $this->instance()->variations()->updateExistingPivot(
            id: $variation->id,
            attributes: [
                // Allow adding the max in stock
                'quantity' => min($quantity, $variation->stockCount()),
            ],
        );
    }

    public function create(?User $user = null)
    {
        $instance = ModelsCart::make()
            ->user()
            ->associate($user);
        $instance->save();

        $this->session->put(config('cart.session.key'), $instance->uuid);
    }

    public function exists()
    {
        return $this->session->has(config('cart.session.key'));
    }

    public function isEmpty(): bool
    {
        return $this->instance()->variations->count() === 0;
    }

    public function items()
    {
        return $this->instance()->variations;
    }

    public function remove(Variation $variation)
    {
        $this->instance()->variations()->detach($variation);
    }

    public function removeAll()
    {
        $this->instance()->variations()->detach();
    }

    public function subTotal(): Money
    {
        return money($this->instance()
            ->variations
            ->reduce(function ($carry, $variation) {
                return ($carry + ($variation->price->getAmount() * $variation->pivot->quantity));
            }, 0));
    }

    /**
     * We should sync the quantities the user has selected
     * with whatever is available in stock
     *
     * @return void
     */
    public function syncAvailableQuantities()
    {
        $syncedQuantities = $this->instance->variations->mapWithKeys(function ($variation) {
            $quantity = ($variation->pivot->quantity > $variation->stockFigures->stockCount)
                ? $variation->stockFigures->stockCount
                : $variation->pivot->quantity;

            return [
                $variation->id => [
                    'quantity' => $quantity,
                ],
            ];
        })
        ->reject(function ($syncedQuantity) {
            return $syncedQuantity['quantity'] === 0;
        });

        $this->instance()->variations()->sync($syncedQuantities);

        $this->clearInstanceCache();
    }

    public function toResource(): CartResource
    {
        return new CartResource($this);
    }

    /**
     * By the time the user is checking out, another user
     * might have completed their transactions and quantities
     * have changed
     *
     * @throws Exception
     */
    public function verifyAvailableQuantities()
    {
        $this->instance()->variations->each(
            function ($variation) {
           if ($variation->pivot->quantity > $variation->stockFigures->stockCount)
           {
                throw new QuantityNoLongerAvailableException('Stock reduced!');
           }
        });
    }

    protected function clearInstanceCache()
    {
        $this->instance = null;
    }

    protected function instance(): ModelsCart
    {
        if (!isset($this->instance)) {
            $this->instance = $this->getCart->execute($this->session);
        }

        return $this->instance;
    }

    protected function getVariation($variation)
    {
        return $this->instance()->variations->find($variation->id);
    }
}