<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => 'required|string|max:50',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|string|min:8'
        ];
    }
    public function messages(): array
    {
        return [
            "name.required"=>"You must enter your name.",
            "name.min"=>"Name should be maximum 50 characters",
            
            "email.email"=>"Incorrect email format",
            "email.required"=>"You must enter your email.",
            "email.unique"=>"Email already used",

            "password.min"=>"Password should be minimum 8 characters",
            "password.required"=>"You must enter password.",
        ];
    }
}
