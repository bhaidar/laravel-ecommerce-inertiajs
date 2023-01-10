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
            'shippingType' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'shipping.address.required' => 'The shipping address is required.',
            'shipping.address.max' => 'The shipping address must not be greater than 255 characters.',
            'shipping.city.required' => 'The shipping city is required.',
            'shipping.city.max' => 'The shipping city must not be greater than 255 characters.',
            'shipping.postCode.required' => 'The shipping postcode is required.',
            'shipping.postCode.max' => 'The shipping postcode must not be greater than 255 characters.',
            'shippingTYpe.required' => 'The shipping type is required.',
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
