<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'subTotal' => $this->subtotal,
            'createdAt' => $this->created_at->toDateTimeString(),
            'shippingType' => ShippingTypeResource::make($this->whenLoaded('shippingType')),
        ];
    }
}
