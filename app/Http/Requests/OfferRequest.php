<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100|unique:offers,name',
            'price' => 'required|numeric',
            'detalis' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => __('messages.offer name required'),
            'name.unique' => __('messages.name unique'),
            'price.numeric' => __('messages.price numeric'),
            'price.required' => __('messages.price required'),
            'detalis.required' => __('messages.detalis required'),
        ];

    }
}
