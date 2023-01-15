<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetOrderVariations
{
    public function execute(User $user): Collection
    {
        return $user
            ->orders()
            ->with([
                'shippingType',
                'variations.media',
                'variations.product:id,title',
                'variations.ancestorsAndSelf',
            ])
            ->get()
            ->each(function (Order $order) {
               $order->variations?->each?->getMediaUrls();
            });
    }
}