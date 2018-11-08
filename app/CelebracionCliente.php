<?php

namespace JME;

use Illuminate\Database\Eloquent\Model;

class CelebracionCliente extends Model
{
    protected $table = 'celebraciones_clientes';

  	protected $fillable = [
                          'fecha',
                          'cliente_id',
                          'celebracion_id'
                        ];

  	public $timestamps = false;

  	  /**
	  *     Foreign Keys functions
	  **/
  	  
  	public function celebracion()
	{
	    return $this->belongsTo('JME\Celebracion', 'celebracion_id');
	}  

  	public function cliente()
	{
	    return $this->belongsTo('JME\Cliente', 'cliente_id');
	}

    public function celebraciones_mesa()
  {
      return $this->hasMany('JME\CelebracionMesa', 'celebracion_cliente_id');
  }
}
