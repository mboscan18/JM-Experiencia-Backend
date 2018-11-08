<?php

namespace JME\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FotosMesaRequest extends FormRequest
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
            'descripcion'                  => 'required|string',
            'mesa_id'                 => 'required',
        ];
    }

    public function messages()
    {
        return [
            'descripcion.required'    => 'La descripción de la Referencia de Foto no puede estar vacía',
        ];
    }
}
