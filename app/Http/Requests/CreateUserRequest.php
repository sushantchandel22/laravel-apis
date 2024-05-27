<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username'=> 'required|unique:users',
            'firstname' => "required|string|max:255",
            'lastname' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users",
            'password' => "required|min:6",
            'city'=>"required",
            'street'=>'required',
            'zipcode'=>'required|max:5',
            'phone'=>'required|max:10',
            'longitude'=>'required',
            'latitude'=>'required'
        ];

    }
}
