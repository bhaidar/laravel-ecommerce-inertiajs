<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'liveAt' => $this->live_at,
            'medias' => $this->whenLoaded('media') ? $this->medias : [],
            'price' => $this->price,
            'slug' => $this->slug,
            'title' => $this->title,
            'variations' => VariationResource::collection($this->whenLoaded('variations')),
        ];
    }
}