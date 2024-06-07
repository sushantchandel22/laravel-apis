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
        return [
            'title'=>"required",
            'description'=>"required",
            'price'=>'required',
            'image.*' => 'sometimes|file|mimes:jpg,jpeg,png',
            'delete_images.*' => 'sometimes|integer|exists:product_images,id',
        ];
    }
}
