<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'firstname'=>'required|string|regex:/^[^\d]+$/',
            'lastname'=>'required|string|regex:/^[^\d]+$/',
            'city'=>'required',
            'street'=>'required',
            'zipcode'=>'required',
            'phone'=>'required'
        ];
    }
}
