<?php

namespace App\Listeners;

use App\Models\Order;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AttachOrders
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Associate orders with the registered user
     * provided there is email match
     *
     * @param Registered $event
     * @return void
     */
    public function handle(Registered $event): void
    {
        Order::query()
            ->whereEmail($event->user->email)
            ->get()
            ->each(function (Order $order) use ($event) {
                $order
                    ->user()
                    ->associate($event->user)
                    ->save();
            });
    }
}
