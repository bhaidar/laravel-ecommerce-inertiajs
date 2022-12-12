<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartVariationRequest extends FormRequest
{
    protected array $notification = [
        'title' => "Couldn't add to cart",
        'message' => 'Your item was not added to cart!',
        'color' => 'red',
    ];

    protected function success()
    {
        $this->notification = [
            'title' => 'Added to cart',
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
