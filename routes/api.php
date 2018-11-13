<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
*/

Route::post('login', 'AuthController@login');
Route::post('signup', 'AuthController@signup');
Route::middleware(['auth:api'])->get('logout', 'AuthController@logout');

/*
|--------------------------------------------------------------------------
| Resources Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth:api'])->group(function () {
	Route::apiResources([
	    'user' 				=> 'UserController',
	    'mesa' 				=> 'MesaController',
	    'foto_mesa' 		=> 'FotoMesaController',
	    'correo' 			=> 'CorreoController',
	    'cliente_mesa'		=> 'ClienteMesaController',
	    'celebracion_mesa'	=> 'CelebracionMesaController',
	    'cliente'			=> 'ClienteController',
	    'celebracion'		=> 'CelebracionController',
	    'datos' 			=> 'DatoController'
	]);
	Route::get('deleted_clientes', 'ClienteController@showDeletes');
	Route::get('restore_cliente/{id}', 'ClienteController@restore');
	Route::get('celebraciones_cliente/{id}', 'ClienteController@celebraciones_cliente');
});	

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
*/

Route::post('cliente', 'ClienteController@store');
Route::get('celebracion', 'CelebracionController@index');

/*
|--------------------------------------------------------------------------
| Mesas Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth:api'])->group(function () {
	Route::get('mesas_active', 'MesaController@indexActive');
	Route::get('historial_mesas/{fecha}', 'MesaController@historialMesas');
	Route::get('historial_mesas_headers/{fecha}', 'MesaController@historialMesasHeaders');
	
	Route::get('mesas_cliente/{id}', 'MesaController@mesas_cliente');
	Route::get('fotos_mesa/{id}', 'FotoMesaController@fotosMesa');
	Route::get('clientes_mesa/{id}', 'ClienteMesaController@clientesMesa');
	Route::get('celebraciones_mesa/{id}', 'CelebracionMesaController@celebracionesMesa');
	Route::get('clientes_mesa_check/{id}', 'ClienteMesaController@clientesMesaCheck');
	Route::get('celebraciones_mesa_check/{id}', 'CelebracionMesaController@celebracionesMesaCheck');
	
});

/*
|--------------------------------------------------------------------------
| Correos Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth:api'])->group(function () {
	Route::get('clientes_correo/{id}', 'CorreoController@clientesCorreo');
	Route::get('correos_categoria/{categoria}', 'CorreoController@correosByCategoria');
});	