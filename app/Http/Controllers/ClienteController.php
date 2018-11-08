<?php

namespace JME\Http\Controllers;

use JME\Cliente;
use JME\CelebracionCliente;
use JME\Http\Requests\ClienteEditRequest;
use JME\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function celebraciones_cliente($id_cliente)
    {
        $data = CelebracionCliente::all()->where('cliente_id', $id_cliente);

        $response = array();
        $i=0;
        foreach ($data as $key) {
            $response[$i]['id']          = $key->id;
            $response[$i]['fecha']       = $key->fecha;
            $response[$i]['cliente_id']  = $key->cliente_id;
            $response[$i]['celebracion'] = $key->celebracion;
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
    public function store(ClienteRequest $request)
    {

        $cliente = Cliente::create($request->all());

        foreach ($request->celebraciones_cliente as $key) {
            $celebracion_cliente = new CelebracionCliente();
            $celebracion_cliente->cliente_id = $cliente->id;
            $celebracion_cliente->celebracion_id = $key['celebracion_id'];
            $celebracion_cliente->fecha = $key['fecha'];
            $celebracion_cliente->save();
        }

        return response()->json([
            'message' => '¡Cliente Creado Exitosamente!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);
        return response()->json($cliente);
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
        $cliente = Cliente::find($id);
        $cliente->update($request->all());
        $cliente->save();

        foreach ($request->celebracion_cliente as $key) {
            if($key['id']){
                $celebracion_cliente = CelebracionCliente::find($key['id']);
            }else{
                $celebracion_cliente = new CelebracionCliente();
            }

            if($key['deleted']){
                $celebracion_cliente->delete();
            }else{
                $celebracion_cliente->cliente_id = $id;
                $celebracion_cliente->celebracion_id = $key['celebracion_id'];
                $celebracion_cliente->fecha = $key['fecha'];
                $celebracion_cliente->save();
            }
        }

        return response()->json([
            'message' => '¡Cliente Actualizado Exitosamente!'
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
        $cliente = Cliente::find($id);
        $cliente->delete();

        return response()->json([
            'message' => '¡Cliente Eliminado Exitosamente!'
        ]);
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDeletes()
    {
        $deleted_clientes = Cliente::onlyTrashed()->get();

        return response()->json($deleted_clientes);
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Cliente::onlyTrashed()->where('id', $id)->restore();

        return response()->json([
            'message' => '¡Cliente Restaurado Exitosamente!'
        ]);
    }
}
