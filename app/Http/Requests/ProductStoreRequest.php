<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'product_name' => 'required|unique:products,product_name|string|min:3',
            'product_code' => 'required|unique:products,product_code|string|min:3',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|max:1000',
            'regular_price' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            "chart" => 'nullable',
            "shipping" => 'nullable',
            "max_capacity" => 'nullable',
            'eqt' => 'required',
            'condition' => 'required',
            'location' => 'required',
            'discount_price' => 'nullable',
        ];
    }
}
