<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
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
            'displayName' => $this->display_name,
            'medias' => $this->whenLoaded('media') ? $this->medias : [],
            'order' => $this->order,
            'parentId' => $this->parent_id,
            'price' => $this->price,
            'productId' => $this->product_id,
            'productTitle' => $this->relationLoaded('product') ? $this->product->title : '',
            'sku' => $this->sku,
            'stockFigures' => $this->stockFigures ?? [],
            'title' => $this->title,
            'type' => $this->type,
            'quantity' => $this->relationLoaded('pivot') ? $this->pivot->quantity : 0,
            'ancestorsAndSelf' => VariationResource::collection($this->whenLoaded('ancestorsAndSelf')),
            'children' => VariationResource::collection($this->whenLoaded('children')),
        ];
    }
}
