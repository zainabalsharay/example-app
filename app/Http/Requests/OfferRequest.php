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
            'name_ar' => 'required|max:100|unique:offers,name_ar',
            'name_en' => 'required|max:100|unique:offers,name_en',
            'price' => 'required|numeric',
            'detalis_ar' => 'required',
            'detalis_en' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name_ar.required' => __('messages.offer name required'),
            'name_ar.unique' => __('messages.name unique'),
            'name_en.required' => __('messages.offer name required'),
            'name_en.unique' => __('messages.name unique'),
            'price.numeric' => __('messages.price numeric'),
            'price.required' => __('messages.price required'),
            'detalis_ar.required' => __('messages.detalis required'),
            'detalis_en.required' => __('messages.detalis required'),
        ];

    }
}
