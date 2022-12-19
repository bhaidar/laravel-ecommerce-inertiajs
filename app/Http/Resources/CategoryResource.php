<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ancestors' => CategoryResource::collection($this->whenLoaded('ancestors')),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'depth' => $this->depth,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'slug' => $this->slug,
            'title' => $this->title,
        ];
    }
}
