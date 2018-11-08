<?php

namespace JME;

use Illuminate\Database\Eloquent\Model;

class Celebracion extends Model
{
    protected $table = 'celebraciones';

  	protected $fillable = [
                          'descripcion'
                        ];

  	public $timestamps = false;

  	  /**
	  *     Foreign Keys functions
	  **/
  	  
  	public function celebraciones_cliente()
	{
	    return $this->hasMany('JME\CelebracionCliente', 'celebracion_id');
	}
}
