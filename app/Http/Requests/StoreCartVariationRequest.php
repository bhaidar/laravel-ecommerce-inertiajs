<?php

namespace App\Http\Requests;

use App\Models\Variation;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartVariationRequest extends FormRequest
{
    public array $notification = [
        'title' => "Couldn't add to cart",
        'message' => 'Your item was not added to cart!',
        'color' => 'red',
    ];

    public function success(Variation $variation = null)
    {
        $this->notification = [
            'title' => "({$variation?->product?->title}) added to cart",
            'message' => 'Your item has been successfully added! ',
            'color' => 'green',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'variation' => ['required', 'integer',],
            'quantity' => ['sometimes', 'required', 'integer'],
        ];
    }
}
