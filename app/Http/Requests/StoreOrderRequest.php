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
            //
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes(
            attribute: 'email',
            rules: 'required|email|max:255|unique:users,email',
            callback: fn ($input) => auth()->guest(),
        );
    }
}
