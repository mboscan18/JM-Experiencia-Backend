<?php

namespace JME;
use DB;

use Illuminate\Database\Eloquent\Model;

class FotoMesa extends Model
{
    protected $table = 'fotos_mesa';

  	protected $fillable = [
                          'descripcion',
                          'mesa_id'
                        ];

  	public $timestamps = false;


    public static function buscarFoto($id_foto, $id_mesa)
    {
         $data = DB::table('fotos_mesa')
             ->select('*')
             ->where('id', $id_foto)
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

}
