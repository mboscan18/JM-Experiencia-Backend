<?php

namespace JME\Http\Controllers;

use Illuminate\Http\Request;
use JME\CelebracionCliente;
use JME\CelebracionMesa;
use JME\Mesa;

class CelebracionMesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CelebracionMesa::all();
        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function celebracionesMesa($id_mesa)
    {
        $data = CelebracionMesa::all()->where('mesa_id', $id_mesa);
        $response = array();
        $i=0;
        foreach ($data as $key) {
            $response[$i]['id']                         = $key->id;
            $response[$i]['celebracion_cliente_id']     = $key->celebracion_cliente_id;
            $response[$i]['celebracion_descripcion']    = $key->celebracion_cliente->celebracion->descripcion;
            $response[$i]['cliente_name']               = $key->celebracion_cliente->cliente->name;
            $i++;
        }

        return response()->json($response);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function celebracionesMesaCheck($id_mesa)
    {
        $mesa = Mesa::find($id_mesa);
        $data = CelebracionCliente::all();
        $response = array();
        $i=0;
        foreach ($data as $celebracion) {
            $response[$i]['id']                         = $celebracion->id;
            $response[$i]['cliente_id']                 = $celebracion->cliente_id;
            $response[$i]['celebracion_id']             = $celebracion->celebracion_id;
            $response[$i]['celebracion_descripcion']    = $celebracion->celebracion->descripcion;
            $response[$i]['cliente_name']               = $celebracion->cliente->name;

            $cont = 0;
            if(sizeof($mesa->celebraciones_mesa) > 0){
                foreach ($mesa->celebraciones_mesa as $key) {
                    if($key->celebracion_cliente_id == $celebracion->id){
                        $response[$i]['check_mesa'] = "checked";
                        $cont++;
                    }
                }
                if($cont == 0)
                    $response[$i]['check_mesa'] = "N";

            }else{
                $response[$i]['check_mesa'] = "N";
            }

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
    public function store(Request $request)
    {
        foreach ($request->celebraciones_mesa as $key) {

            $cliente = CelebracionMesa::buscarCelebracion($key['celebracion_cliente_id'], $request->mesa_id);

            if(sizeof($cliente) == 0){
                $celebracion_mesa                           = new CelebracionMesa();
                $celebracion_mesa->mesa_id                  = $request->mesa_id; 
                $celebracion_mesa->celebracion_cliente_id   = $key['celebracion_cliente_id'];
                $celebracion_mesa->save();
            }
        }

        if(sizeof($request->celebraciones_mesa)>1){
            return response()->json([
                'message' => 'Celebraciones Agregadas Exitosamente!'
            ]);
        }else{
            return response()->json([
                'message' => 'Celebración Agregada Exitosamente!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = CelebracionMesa::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $celebracion_mesa = CelebracionMesa::find($id);
        $celebracion_mesa->update($request->all());
        $celebracion_mesa->save();

        return response()->json([
            'message' => 'Celebración Actualizada Exitosamente!'
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
        $celebracion_mesa = CelebracionMesa::find($id);
        $celebracion_mesa->delete();

        return response()->json([
            'message' => 'Celebración Eliminada Exitosamente!'
        ]);
    }
}
