<?php

namespace App\Http\Resources;

use App\Cart\Contracts\CartInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $items = $this->items();

        return [
            'items' => VariationResource::collection($items),
            'count' => $items->count() ?? 0,
            'subTotal' => $this->formattedSubTotal(),
        ];
    }
}
