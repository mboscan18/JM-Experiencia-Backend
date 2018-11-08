<?php

namespace JME\Http\Controllers;

use JME\Celebracion;
use JME\Http\Requests\CelebracionRequest;
use Illuminate\Http\Request;

class CelebracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Celebracion::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CelebracionRequest $request)
    {
        Celebracion::create($request->all());

        return response()->json([
            'message' => 'Celebración Creada Exitosamente!'
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
        $data = Celebracion::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CelebracionRequest $request, $id)
    {
        $celebracion = Celebracion::find($id);
        $celebracion->update($request->all());
        $celebracion->save();

        return response()->json([
            'message' => 'Celebracion Actualizada Exitosamente!'
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
        $celebracion = Celebracion::find($id);
        $celebracion->delete();

        return response()->json([
            'message' => 'Celebracion Eliminada Exitosamente!'
        ]);
    }
}
