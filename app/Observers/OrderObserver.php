<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderObserver
{
    public function creating (Order $order): void
    {
        $order->placed_at = now();
        $order->uuid = (string)Str::uuid();
    }

    public function updating (Order $order): void
    {
        // construct original order from original columns
        $originalOrder = new Order(
            collect($order->getOriginal())
            ->only($order->statuses)
            ->toArray()
        );

        // getDirty(): Get the attributes that have been changed since the last sync.
        $filledStatuses = collect($order->getDirty())
            ->only(array_keys($order->statuses)) // only columns we want
            ->filter(fn ($status) => filled($status)); // only those filled with values not set to null to get the real columns updated

        // If there is a change in the status in the right order, then send email
        // Placed At -> Packaged At -> Shipped At
        if ($originalOrder->status() !== $order->status() && $filledStatuses->count() > 0)
        {
           // send email
           dd('send email');
        }
    }
}
