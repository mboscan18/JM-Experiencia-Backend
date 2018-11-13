<?php

namespace JME\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            'name'                  => 'required|string',
            'email'                 => 'required|string|email||unique:clientes',
            'whatsapp'              => 'required|',
            'direccion'             => 'required|string',
            'celebraciones_cliente'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.unique'    => 'El E-Mail Introducido ya está registrado.',
            'celebraciones_cliente.required'    => 'Debe agregar por lo menos una Celebración.',
        ];
    }
}
