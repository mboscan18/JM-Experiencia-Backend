<?php

namespace JME;
use DB;

use Illuminate\Database\Eloquent\Model;

class ClienteMesa extends Model
{
    protected $table = 'clientes_mesa';

  	protected $fillable = [
                          'mesa_id',
                          'cliente_id'
                        ];

  	public $timestamps = false;

    public static function buscarCliente($id_cliente, $id_mesa)
    {
         $data = DB::table('clientes_mesa')
             ->select('*')
             ->where('cliente_id', $id_cliente)
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

  	public function cliente()
	{
	    return $this->belongsTo('JME\Cliente', 'cliente_id');
	}

}
