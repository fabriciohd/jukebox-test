<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title'                     => 'required',
            'description'               => 'required',
            'status'                    => 'nullable|integer|between:1,3',
            'date'                      => 'required|date',
            'time'                      => 'nullable|date_format:H:i',
        ];

        if($this->method() === 'PUT'){
            $rules = [
                'title'                     => 'nullable',
                'description'               => 'nullable',
                'status'                    => 'nullable|integer|between:1,3',
                'date'                      => 'nullable|date',
                'time'                      => 'nullable|date_format:H:i',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required'                         => "O campo Título é obrigatório",
            'description.required'                   => "O campo Descrição é obrigatório",
            'status.integer'                         => "Status inválido",
            'status.between'                         => "Status inválido",
            'date.required'                          => "O campo Data é obrigatório",
            'date.date'                              => "Data inválida",
            'time.date_format'                       => "Hora inválida",
        ];
    }
}
