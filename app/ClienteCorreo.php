<?php

namespace JME;

use Illuminate\Database\Eloquent\Model;

class ClienteCorreo extends Model
{
    protected $table = 'clientes_correo';

  	protected $fillable = [
                          'correo_id',
                          'cliente_id'
                        ];

  	public $timestamps = false;

  	  /**
	  *     Foreign Keys functions
	  **/
  	  
  	public function mesa()
	{
	    return $this->belongsTo('JME\Correo', 'correo_id');
	}  

  	public function cliente()
	{
	    return $this->belongsTo('JME\Cliente', 'cliente_id');
	}
}
