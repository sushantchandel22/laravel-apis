<?php

namespace App\Http\Requests\User;

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
            'firstname' => "required|string|max:255|regex:/^[^\d]+$/",
            'lastname' => "required|string|max:255|regex:/^[^\d]+$/",
            'email' => "required|string|email|max:255|unique:users",
            'password' => "required|min:6|max:15",
            'city'=>"required",
            'street'=>'required',
            'zipcode'=>'required|min:5',
            'phone'=>'required|min:10|max:10',
            'longitude'=>'required',
            'latitude'=>'required'
        ];

    }
}
