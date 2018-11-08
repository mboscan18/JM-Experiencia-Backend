<?php

namespace JME\Http\Controllers;

use Illuminate\Http\Request;
use JME\ClienteMesa;
use JME\Cliente;
use JME\Mesa;

class ClienteMesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ClienteMesa::all();
        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientesMesa($id_mesa)
    {
        $data = ClienteMesa::all()->where('mesa_id', $id_mesa);
        $response = array();
        $i=0;
        foreach ($data as $key) {
            $response[$i]['id']             = $key->id;
            $response[$i]['mesa_id']        = $key->mesa_id;
            $response[$i]['cliente_id']     = $key->cliente_id;
            $response[$i]['cliente_name']   = $key->cliente->name;
            $response[$i]['cliente_email']  = $key->cliente->email;
            $i++;
        }

        return response()->json($response);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientesMesaCheck($id_mesa)
    {
        $mesa = Mesa::find($id_mesa);
        $data = Cliente::all();
        $response = array();
        $i=0;
        foreach ($data as $cliente) {
            $response[$i]['id']         = $cliente->id;
            $response[$i]['name']       = $cliente->name;
            $response[$i]['email']      = $cliente->email;

            $cont = 0;
            if(sizeof($mesa->clientes_mesa) > 0){
                foreach ($mesa->clientes_mesa as $key) {
                    if($key->cliente_id == $cliente->id){
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
        foreach ($request->clientes as $key) {

            $cliente = ClienteMesa::buscarCliente($key['cliente_id'], $request->mesa_id);

            if(sizeof($cliente) == 0){
                $cliente_mesa               = new ClienteMesa();
                $cliente_mesa->mesa_id      = $request->mesa_id; 
                $cliente_mesa->cliente_id   = $key['cliente_id'];
                $cliente_mesa->save();
            }
        }

        if(sizeof($request->clientes)>1){
            return response()->json([
                'message' => 'Clientes Agregados Exitosamente!'
            ]);
        }else{
            return response()->json([
                'message' => 'Cliente Agregado Exitosamente!'
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
        $data = ClienteMesa::find($id);
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
        $cliente_mesa = ClienteMesa::find($id);
        $cliente_mesa->update($request->all());
        $cliente_mesa->save();

        return response()->json([
            'message' => 'Cliente Actualizada Exitosamente!'
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
        $cliente_mesa = ClienteMesa::find($id);
        $cliente_mesa->delete();

        return response()->json([
            'message' => 'Cliente Removido Exitosamente!'
        ]);
    }
}
