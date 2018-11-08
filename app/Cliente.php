<?php

namespace JME;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';

  	protected $fillable = [
                          'name',
                          'email',
                          'whatsapp',
                          'telefono',
                          'direccion'
                        ];
                        
	protected $dates = ['deleted_at'];		

  	public $timestamps = false;

  	public static function clienteByEmail($email)
    {
         $data = DB::table('clientes')
             ->select('id')
             ->where('email', $email)
             ->get();

         return $data[0]->id;    
    }

  	  /**
	  *     Foreign Keys functions
	  **/
  	  
  	public function clientes_mesa()
	{
	    return $this->hasMany('JME\ClienteMesa', 'cliente_id');
	}

	public function clientes_correo()
	{
	    return $this->hasMany('JME\ClienteCorreo', 'cliente_id');
	}

	public function celebraciones_cliente()
	{
	    return $this->hasMany('JME\CelebracionCliente', 'cliente_id');
	}
}
