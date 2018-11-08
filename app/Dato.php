<?php

namespace JME;

use Illuminate\Database\Eloquent\Model;
use DB;

class Dato extends Model
{
    protected $table = 'datos';

  	protected $fillable = [
                          'num_mesas'
                        ];

  	public $timestamps = false;

  	public static function getNumTotalMesas(){
  		$data = DB::table('datos')
             ->select('*')
             ->orderBy('num_mesas','desc')
             ->first();

          if ($data)
              return $data->num_mesas;    
          else  
              return null;  
  	}
}
