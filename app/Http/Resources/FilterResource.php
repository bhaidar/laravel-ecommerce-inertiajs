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
                    // A hacky way to convert int-keys to string-keys
                    // On the frontend, I will replace [ and ] with empty string for display
                    return ['[' . $filterKey . ']' => $filterValue];
                });

                return [$key => $filter];
            })->toArray();
    }
}
