<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                     => "O campo Nome é obrigatório",
            'email.required'                    => "O campo Email é obrigatório",
            'email.email'                       => "O campo email deve ser um email válido obrigatório",
            'email.unique'                      => "Email já cadastrado",
            'password.required'                 => "Senha obrigatória",
            'password.confirmed'                => "Confirmação de Senha inválida",
        ];
    }
}
