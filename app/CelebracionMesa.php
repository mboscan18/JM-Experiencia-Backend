<?php

namespace JME;
use DB;

use Illuminate\Database\Eloquent\Model;

class CelebracionMesa extends Model
{
    protected $table = 'celebraciones_mesa';

  	protected $fillable = [
                          'mesa_id',
                          'celebracion_cliente_id'
                        ];

  	public $timestamps = false;


    public static function buscarCelebracion($id_celebracion_cliente, $id_mesa)
    {
         $data = DB::table('celebraciones_mesa')
             ->select('*')
             ->where('celebracion_cliente_id', $id_celebracion_cliente)
             ->where('mesa_id', $id_mesa)
             ->get();

          if ($data)
              return $data;    
          else  
              return null;    
    }

  	  /**
	  *     Foreign Keys functions
	  **/
  	  
  	public function mesa()
	{
	    return $this->belongsTo('JME\Mesa', 'mesa_id');
	}  

  	public function celebracion_cliente()
	{
	    return $this->belongsTo('JME\CelebracionCliente', 'celebracion_cliente_id');
	}
}
