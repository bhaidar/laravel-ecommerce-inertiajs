<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use JsonSerializable;

class FilterResource extends JsonResource
{
   /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return collect($this->resource)
            ->mapWithKeys(function ($filter, $key) {
                if (!is_array($filter)) {
                    return $filter;
                }

                // Make filter array keys as string
                $filter = collect($filter)->mapWithKeys(function ($filterValue, $filterKey) use ($key) {
                    return [Str::title('[' . $filterKey . ']') => $filterValue];
                });

                return [Str::title($key) => $filter];
            })->toArray();
    }
}
