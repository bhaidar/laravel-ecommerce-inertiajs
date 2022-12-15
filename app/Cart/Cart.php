<?php

namespace App\Cart;

use App\Cart\Contracts\CartInterface;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Collection;
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

    public function items()
    {
        return $this->instance()->variations;
    }

    public function add($variation, int $quantity = 1)
    {
        // Increment quantity when a variation already exists in the cart
        if ($existingVariation = $this->getVariation($variation)) {
             $quantity += $existingVariation->pivot->quantity;
        }

        $this->instance()->variations()->syncWithoutDetaching([
            $variation->id => [
                // Allow adding the max in stock
                'quantity' => min($quantity,$variation->stocks->sum('amount')),
            ],
        ]);
    }

    protected function getVariation($variation)
    {
        return $this->instance()->variations->find($variation->id);
    }

    protected function instance()
    {
        if (!isset($this->instance)) {
            $this->instance = ModelsCart::with(['variations', 'variations.media', 'variations.product:id,title'])
                ->whereUuid(
                    $this->session->get(
                        config('cart.session.key')
                    )
                )->firstOrFail();

            // Populate variation media urls
            $this->populateVariationMediaUrls($this->instance->variations);
        }

        return $this->instance;
    }

    /**
     * @param Collection $variations
     * @return void
     */
    private function populateVariationMediaUrls(Collection $variations): void
    {
        $variations->each->getMediaUrls();
    }
}