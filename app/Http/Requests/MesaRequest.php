<?php

namespace JME\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JME\Mesa;

class MesaRequest extends FormRequest
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
        $lastClausura = Mesa::lastClausura($this->num_mesa);
        if($lastClausura){
            return [
                'num_mesa'        => 'required|numeric|unique:mesas,num_mesa,'.$this->id.',id,apertura,'.$this->apertura,
                'apertura'        => 'required|date_format: "Y-m-d H:i"|after:.'.$lastClausura,
                'clausura'        => 'nullable|date_format: "Y-m-d H:i"|after:apertura',
                'etiqueta'        => 'string|max:45',
            ];
        }else{
           return [
                'num_mesa'        => 'required|numeric|unique:mesas,num_mesa,'.$this->id.',id,apertura,'.$this->apertura,
                'apertura'        => 'required|date_format: "Y-m-d H:i"',
                'clausura'        => 'nullable|date_format: "Y-m-d H:i"|after:apertura',
                'etiqueta'        => 'string|max:45',
            ]; 
        }
    }

    public function messages()
    {
        $lastClausura = Mesa::lastClausura($this->num_mesa);
        return [
            'num_mesa.unique'   => 'Ya fué aperturada la (Mesa '.$this->num_mesa.') a las '.date('g:ia \d\e\l \d\í\a d-M Y', strtotime($this->apertura)),
            'apertura.after'    => 'La apertura de la mesa debe ser despues de las '.date('g:ia \d\e\l \d\í\a d-M Y', strtotime($lastClausura)),            
        ];
    }
}
