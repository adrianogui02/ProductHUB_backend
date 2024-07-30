<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string|max:5000',
            'price'          => 'required|numeric',
            'expiration_date' => 'required|date',
            'image'          => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'category_id'    => 'required|exists:categories,id',
        ];
    }

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
     * @return array
     * Custom validation message
     */
    public function messages(): array
    {
        return [
            'name.required'          => 'Please give product name',
            'name.max'               => 'Please give product name maximum of 255 characters',
            'description.max'        => 'Please give product description maximum of 5000 characters',
            'price.required'         => 'Please give product price',
            'price.numeric'          => 'Please give a numeric product price',
            'expiration_date.required' => 'Please provide an expiration date',
            'expiration_date.date'   => 'Please provide a valid expiration date',
            'image.image'            => 'Please give a valid product image',
            'image.max'              => 'Product image max 2MB is allowed',
            'category_id.required'   => 'Please select a category',
            'category_id.exists'     => 'Selected category does not exist',
        ];
    }
}
