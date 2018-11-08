<?php

namespace JME;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mesa extends Model
{
    protected $table = 'mesas';

  	protected $fillable = [
                          'num_mesa',
                          'apertura',
                          'clausura',
                          'etiqueta'
                        ];

  	public $timestamps = false;

    public static function lastClausura($nro_mesa)
    {
         $data = DB::table('mesas')
             ->select('clausura')
             ->where('num_mesa', $nro_mesa)
             ->orderBy('clausura','desc')
             ->first();

          if ($data)
              return $data->clausura;    
          else  
              return null;    
    }

  	public static function isMesaAbierta($nro_mesa)
    {
         $data = DB::table('mesas')
             ->select(DB::raw('count(*) as is_mesa_abierta'))
             ->where('num_mesa', $nro_mesa)
             ->get();

        return $data[0]->is_mesa_abierta;    
    }

  	  /**
	  *     Foreign Keys functions
	  **/
  	  
  	public function clientes_mesa()
	{
	    return $this->hasMany('JME\ClienteMesa', 'mesa_id');
	}

  	public function fotos_mesa()
	{
	    return $this->hasMany('JME\FotoMesa', 'mesa_id');
	}

  	public function celebraciones_mesa()
	{
	    return $this->hasMany('JME\CelebracionMesa', 'mesa_id');
	}

  	public function correos()
	{
	    return $this->hasMany('JME\Correo', 'mesa_id');
	}

}

