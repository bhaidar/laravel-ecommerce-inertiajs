<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchCartVariationRequest extends FormRequest
{
    public array $notification = [
        'title' => "Couldn't update cart",
        'message' => 'Your item was not updated in the cart!',
        'color' => 'red',
    ];

    public function success()
    {
        $this->notification = [
            'title' => 'Cart updated',
            'message' => 'Your cart has been successfully updated! ',
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
            'variation' => ['required', 'int',],
            'quantity' => ['sometimes', 'required', 'integer',],
        ];
    }
}
