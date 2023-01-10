<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'shipping.address' => ['required', 'max:255'] ,
            'shipping.city' => ['required', 'max:255'],
            'shipping.postCode' => ['required', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'shipping.address.required' => 'The address is required.',
            'shipping.address.max' => 'The address must not be greater than 255 characters.',
            'shipping.city.required' => 'The city is required.',
            'shipping.city.max' => 'The city must not be greater than 255 characters.',
            'shipping.postCode.required' => 'The postcode is required.',
            'shipping.postCode.max' => 'The postcode must not be greater than 255 characters.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes(
            attribute: 'email',
            rules: ['required', 'email', 'max:255', 'unique:users,email'],
            callback: fn ($input) => auth()->guest(),
        );
    }
}
