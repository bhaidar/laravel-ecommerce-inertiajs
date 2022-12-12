<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartVariationRequest extends FormRequest
{
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
