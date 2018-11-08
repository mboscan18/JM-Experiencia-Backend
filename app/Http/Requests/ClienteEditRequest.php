<?php

namespace JME\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteEditRequest extends FormRequest
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
            'email'                 => 'required|string|email',
            'whatsapp'              => 'required|',
            'direccion'             => 'required|string',
            'celebracion_cliente'   => 'required',
            'fecha'                 => 'date',
        ];
    }
    
    public function messages()
    {
        return [
            'celebracion_cliente.required'    => 'Debe agregar por lo menos una Celebración.',
        ];
    }
}
