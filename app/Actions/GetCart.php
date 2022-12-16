<?php

namespace App\Actions;

use App\Models\Cart as ModelsCart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Session\SessionManager;

class GetCart
{
    public function execute(SessionManager $session): ModelsCart
    {
        $instance = ModelsCart::query()
            ->with([
                'variations.media',
                'variations.product:id,title',
                'variations.stocks',
                'variations.ancestorsAndSelf',
            ])
            ->whereUuid($session->get(config('cart.session.key')))
            ->firstOrFail();

        // Populate variation media urls
        $this->populateVariationMediaUrls($instance->variations);

        // Populate Stock
        $this->loadStock($instance->variations);

        return $instance;
    }

    /**
     * @param Collection $variations
     * @return void
     */
    private function populateVariationMediaUrls(Collection $variations): void
    {
        $variations->each->getMediaUrls();
    }

    /**
     * @param Collection $variations
     * @return void
     */
    private function loadStock(Collection $variations): void
    {
        $variations->each->loadStock();
    }
}