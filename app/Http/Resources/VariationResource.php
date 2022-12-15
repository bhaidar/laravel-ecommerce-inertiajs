<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'displayName' => $this->display_name,
            'medias' => $this->whenLoaded('media') ? $this->medias : [],
            'order' => $this->order,
            'parentId' => $this->parent_id,
            'price' => $this->price,
            'productId' => $this->product_id,
            'sku' => $this->sku,
            'title' => $this->title,
            'type' => $this->type,
            'children' => VariationResource::collection($this->whenLoaded('children')),
        ];
    }
}
