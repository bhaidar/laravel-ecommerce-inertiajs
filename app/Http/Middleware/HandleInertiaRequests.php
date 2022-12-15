<?php

namespace App\Http\Middleware;

use App\Cart\Contracts\CartInterface;
use App\Http\Resources\VariationResource;
use App\Models\Cart as ModelsCart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Log;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    public function __construct(protected CartInterface $cart)
    {
    }

    /**
     * Determine the current asset version.
     *
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param Request $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'cart' => function () {
                try {
                    $items = $this->cart->items();
                } catch (ModelNotFoundException $e) {
                    Log::error($e->getMessage());
                    return null;
                }
                return [
                    'items' => VariationResource::collection($items),
                    'count' => $items->count() ?? 0,
                    'total' => $items->sum(fn ($variation) => $variation->pivot->quantity),
                ];
            },
            'flash' => [
                'notification' => fn () => $request->session()->get('notification')
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
