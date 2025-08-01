<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:3',
            'phone'=> 'min:10|max:10',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function messages(): array
    {
        return [
            'phone.min' => 'Phone min 10 numbers',
            'phone.max' => 'Phone max 10 numbers',
        ];
    }
}