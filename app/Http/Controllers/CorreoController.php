<?php

namespace JME\Http\Controllers;

use Illuminate\Http\Request;
use JME\ClienteCorreo;
use JME\Correo;

class CorreoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Correo::all();
        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function correosByCategoria($categoria)
    {
        $data = Correo::all()->where('categoria', $categoria);
        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientesCorreo($id_correo)
    {
        $data = ClienteCorreo::all()->where('correo_id', $id_correo);

        $response = array();
        $i=0;
        foreach ($data as $key) {
            $response[$i]['id']          = $key->id;
            $response[$i]['correo_id']   = $key->correo_id;
            $response[$i]['cliente']     = $key->cliente;
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
        $correo = Correo::create($request->all());

        foreach ($request->clientes as $key) {
            $cliente_correo = new ClienteCorreo();
            $cliente_correo->correo_id = $correo->id;
            $cliente_correo->cliente_id = $key['cliente_id'];
            $cliente_correo->save();
        }

        return response()->json([
            'message' => 'Correo Enviado Exitosamente!'
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
        $correo = Correo::find($id);
        $response = array();
        $response['id']        = $correo->id;
        $response['asunto']    = $correo->asunto;
        $response['cuerpo']    = $correo->cuerpo;
        $response['fecha']     = $correo->fecha;
        $response['categoria'] = $correo->categoria;
        $response['clientes']  = $correo->clientes_correo;
        return response()->json($response);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $correo = Correo::find($id);
        $correo->clientes_correo()->delete();
        $correo->delete();

        return response()->json([
            'message' => 'Correo Eiminado Exitosamente!'
        ]);
    }
}
