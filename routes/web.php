<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/bodega', 'BodegaController@index')->name("bodega");
    Route::post('/bodega/getdatos', 'BodegaController@getdatos')->name("bodega.getdatos");
    Route::post('/bodega/setdatos', 'BodegaController@setdatos')->name("bodega.setdatos");
    Route::get('/pedidos', 'PedidosController@index')->name("pedidos");
    Route::post('/pedidos/getdatos', 'PedidosController@getdatos')->name("pedidos.getdatos");
    Route::post('/pedidos/store', 'PedidosController@store')->name("pedidos.store");
    Route::get('/informes', 'InformesController@index')->name("informes");
    Route::get('/mantenedores', 'MantenedoresController@index')->name("mantenedores");
    Route::post('/mantenedores/getdatos', 'MantenedoresController@getdatos')->name("mantenedores.getdatos");
    Route::post('/mantenedores/setdatos', 'MantenedoresController@setdatos')->name("mantenedores.setdatos");
    Route::get('/configuraciones', 'ConfiguracionController@index')->name("configuraciones");
    Route::post('/sistema/getdatos', 'SistemaController@getdatos')->name("sistema.getdatos");
    Route::post('/sistema/setdatos', 'SistemaController@setdatos')->name("sistema.setdatos");
    Route::post('/sistema/uploadimage', 'SistemaController@uploadimage')->name("sistema.uploadimage");
    Route::get('/ordencompra', 'OrdenCompraController@index')->name("ordencompra");
    Route::post('/ordencompra/setdatos', 'OrdenCompraController@setdatos')->name("ordencompra.setdatos");
    Route::post('/ordencompra/getdatos', 'OrdenCompraController@getdatos')->name("ordencompra.getdatos");

    
});
//Url::forceScheme('https');