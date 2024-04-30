<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'                 => 'required',
            'password'              => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required'                    => "O campo Email é obrigatório",
            'password.required'                 => "Senha obrigatória",
        ];
    }
}
