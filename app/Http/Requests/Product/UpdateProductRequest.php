<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        dd($this->all());
        return [
            'title' => 'string|max:255',
            'description' => 'string|max:1000',
            'price' => 'numeric|min:0',
            'image.*' => 'sometimes|file|mimes:jpg,jpeg,png',
            'delete_images.*' => 'sometimes|integer|exists:product_images,id',
        ];
    }
}
