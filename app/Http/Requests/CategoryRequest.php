<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
<<<<<<<< HEAD:app/Http/Requests/CategoryRequest.php
            'name' => 'required|string|max:255',
========
            'title'=>"required",
            'description'=>"required",
            'price'=>'required',
            'image'=>'required'
>>>>>>>> eabc92f245b52910e927b062e5fcfb14ebeefdb7:app/Http/Requests/UpdateProductRequest.php
        ];
    }
}
