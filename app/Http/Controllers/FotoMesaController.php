<?php

namespace JME\Http\Controllers;

use Illuminate\Http\Request;
use JME\FotoMesa;

class FotoMesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FotoMesa::all();
        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fotosMesa($id_mesa)
    {
        $data = FotoMesa::all()->where('mesa_id', $id_mesa);
        $response = array();
        $i=0;
        foreach ($data as $key) {
            $response[$i]['id']             = $key->id;
            $response[$i]['mesa_id']        = $key->mesa_id;
            $response[$i]['descripcion']    = $key->descripcion;
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
        foreach ($request->fotos_mesa as $key) {

            $foto = FotoMesa::buscarFoto($key['id'], $request->mesa_id);

            if(sizeof($foto) == 0){
                $foto_mesa               = new FotoMesa();
                $foto_mesa->mesa_id      = $request->mesa_id; 
                $foto_mesa->descripcion   = $key['descripcion'];
                $foto_mesa->save();
            }
        }

        if(sizeof($request->fotos_mesa)>1){
            return response()->json([
                'message' => 'Referencias de Foto Agregadas Exitosamente!'
            ]);
        }else{
            return response()->json([
                'message' => 'Referencia de Foto Agregada Exitosamente!'
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
        $data = FotoMesa::find($id);
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
        $foto_mesa = FotoMesa::find($id);
        $foto_mesa->update($request->all());
        $foto_mesa->save();

        return response()->json([
            'message' => 'Referencia de Foto Actualizada Exitosamente!'
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
        $foto_mesa = FotoMesa::find($id);
        $foto_mesa->delete();

        return response()->json([
            'message' => 'Referencia de Foto Eliminada Exitosamente!'
        ]);
    }
}
