<?php

namespace JME;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correos';

  	protected $fillable = [
                          'asunto',
                          'cuerpo',
                          'fecha',
                          'categoria',
                          'mesa_id'
                        ];

  	public $timestamps = false;

  	  /**
	  *     Foreign Keys functions
	  **/
  	  
  	public function clientes_correo()
	{
	    return $this->hasMany('JME\ClienteCorreo', 'correo_id');
	}

  	public function mesa()
	{
	    return $this->belongsTo('JME\Mesa', 'mesa_id');
	}
}
