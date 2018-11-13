<?php

namespace JME\Http\Controllers;

use JME\Mesa;
use JME\FotoMesa;
use JME\ClienteMesa;
use JME\CelebracionMesa;
use JME\Correo;
use JME\Dato;
use JME\Http\Requests\MesaRequest;
use JME\Http\Requests\MesaEditRequest;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mesa = Mesa::all();
        $response = array();
        $i=0;
        foreach ($mesa as $key) {
            $response[$i]['id']           = $key->id;
            $response[$i]['num_mesa']     = $key->num_mesa;
            $response[$i]['apertura']     = $key->apertura;
            $response[$i]['clausura']     = $key->clausura;
            $response[$i]['etiqueta']     = $key->etiqueta;
            $response[$i]['cant_correos_mesa']        = sizeof($key->correos);
            $response[$i]['cant_fotos_mesa']          = sizeof($key->fotos_mesa);
            $response[$i]['cant_clientes_mesa']       = sizeof($key->clientes_mesa);
            $response[$i]['cant_celebraciones_mesa']  = sizeof($key->celebraciones_mesa);
            $i++;
        }

        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexActive()
    {
        $mesa = Mesa::all()->where('clausura', null);
        $response = array();
        $i=0;
        foreach ($mesa as $key) {
            $response[$i]['id']           = $key->id;
            $response[$i]['num_mesa']     = $key->num_mesa;
            $response[$i]['apertura']     = $key->apertura;
            $response[$i]['clausura']     = $key->clausura;
            $response[$i]['etiqueta']     = $key->etiqueta;
            $response[$i]['cant_correos_mesa']        = sizeof($key->correos);
            $response[$i]['cant_fotos_mesa']          = sizeof($key->fotos_mesa);
            $response[$i]['cant_clientes_mesa']       = sizeof($key->clientes_mesa);
            $response[$i]['cant_celebraciones_mesa']  = sizeof($key->celebraciones_mesa);
            $i++;
        }

        return response()->json($response);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mesasByNumero($num_mesa)
    {
        $mesa = Mesa::all()->where('num_mesa', $num_mesa);
        $response = array();
        $i=0;
        foreach ($mesa as $key) {
            $response[$i]['id']           = $key->id;
            $response[$i]['num_mesa']     = $key->num_mesa;
            $response[$i]['apertura']     = $key->apertura;
            $response[$i]['clausura']     = $key->clausura;
            $response[$i]['etiqueta']     = $key->etiqueta;
            $response[$i]['cant_correos_mesa']        = sizeof($key->correos);
            $response[$i]['cant_fotos_mesa']          = sizeof($key->fotos_mesa);
            $response[$i]['cant_clientes_mesa']       = sizeof($key->clientes_mesa);
            $response[$i]['cant_celebraciones_mesa']  = sizeof($key->celebraciones_mesa);
            $i++;
        }

        return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mesasByNumeroArray($num_mesa, $fecha)
    {
        $mesa = Mesa::mesasByFecha($num_mesa, $fecha);
                    
       // $mesa = Mesa::mesasByFecha($num_mesa, $fecha);
        $response = array();
        $i=0;
        foreach ($mesa as $key) {
            $response[$i]['id']           = $key->id;
            $response[$i]['num_mesa']     = $key->num_mesa;
            $response[$i]['apertura']     = $key->apertura;
            $response[$i]['clausura']     = $key->clausura;
            $response[$i]['etiqueta']     = $key->etiqueta;
            $response[$i]['cant_correos_mesa']        = sizeof($key->correos);
            $response[$i]['cant_fotos_mesa']          = sizeof($key->fotos_mesa);
            $response[$i]['cant_clientes_mesa']       = sizeof($key->clientes_mesa);
            $response[$i]['cant_celebraciones_mesa']  = sizeof($key->celebraciones_mesa);
            $i++;
        }

        return $response;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function historialMesas($fecha)
    {
        $num_total_mesas = Dato::getNumTotalMesas();
        $response = array();
        for ($i=0; $i < $num_total_mesas; $i++) { 
            $mesas = $this->mesasByNumeroArray($i+1, $fecha);
            $response[$i]['num_mesa']     = $i+1;
            $response[$i]['cant_mesas']   = sizeof($mesas);
            if(sizeof($mesas) > 0)
                $response[$i]['estatus']        = 'aperturada';
            else
                $response[$i]['estatus']        = 'cerrada';
            $response[$i]['mesas']        = $mesas;
        }

        return $response;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mesas_cliente($id_cliente)
    {
        $cliente_mesa = ClienteMesa::all()->where('cliente_id', $id_cliente);
        $response = array();
        $i=0;
        foreach ($cliente_mesa as $key) {
            $response[$i]['id']           = $key->id;
            $response[$i]['cliente_id']   = $id_cliente;
            $response[$i]['num_mesa']     = $key->mesa->num_mesa;
            $response[$i]['apertura']     = $key->mesa->apertura;
            $response[$i]['clausura']     = $key->mesa->clausura;
            $response[$i]['etiqueta']     = $key->mesa->etiqueta;
            $response[$i]['cant_correos_mesa']        = sizeof($key->mesa->correos);
            $response[$i]['cant_fotos_mesa']          = sizeof($key->mesa->fotos_mesa);
            $response[$i]['cant_clientes_mesa']       = sizeof($key->mesa->clientes_mesa);
            $response[$i]['cant_celebraciones_mesa']  = sizeof($key->mesa->celebraciones_mesa);
            $i++;
        }

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MesaRequest $request)
    {
        $is_mesa_abierta = Mesa::isMesaAbierta($request->num_mesa);
        if($is_mesa_abierta == 0){
            Mesa::create($request->all());
            return response()->json([
                'message' => 'Mesa Creada Exitosamente!'
            ]);
        }
        $response = array();
        $response['error']['errors']['num_mesa'][0] = 'No puede aperturar la Mesa '.$request->num_mesa.', porque aún se encuentra activa.';
        return response()->json($response);    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mesa = Mesa::find($id);
        $response = array();
        $response['id']           = $mesa->id;
        $response['num_mesa']     = $mesa->num_mesa;
        $response['apertura']     = $mesa->apertura;
        $response['clausura']     = $mesa->clausura;
        $response['etiqueta']     = $mesa->etiqueta;
        $response['cant_correos_mesa']        = sizeof($mesa->correos);
        $response['cant_fotos_mesa']          = sizeof($mesa->fotos_mesa);
        $response['cant_clientes_mesa']       = $mesa->clientes_mesa;
        $response['cant_celebraciones_mesa']  = $mesa->celebraciones_mesa;
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MesaEditRequest $request, $id)
    {
        $mesa = Mesa::find($id);
        $mesa->update($request->all());
        $mesa->save();

        return response()->json([
            'message' => 'Mesa Actualizada Exitosamente!',
            'mesa' => $mesa
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mesa = Mesa::find($id);
        $mesa->fotos_mesa()->delete();
        $mesa->clientes_mesa()->delete();
        $mesa->celebraciones_mesa()->delete();
        $mesa->delete();

        return response()->json([
            'message' => 'Mesa Eliminada Exitosamente!'
        ]);
    }
}
