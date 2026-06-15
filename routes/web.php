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
Route::get('/inicio', 'HomeController@inicio')->name('inicio');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/warehouse', 'WareHouseController@index')->name("warehouse");
    Route::get('/operation', 'OperationController@index')->name("operation");
    Route::get('/operation/servicio', 'Operation\ServiciosController@index')->name("operation.servicios");
    Route::post('/operation/getdatos', 'Operation\ServiciosController@getdatos')->name("operation.getdatos");
    Route::post('/operation/setdatos', 'Operation\ServiciosController@setdatos')->name("operation.setdatos");
    Route::get('/operation/informe', 'Operation\InformesController@index')->name("operation.informes");
    Route::get('/operation/mantenedores', 'Operation\MantenedoresController@index')->name("operation.mantenedores");
    Route::get('/warehouse/bodega', 'Warehouse\BodegaController@index')->name("warehouse.bodega");
    Route::post('/bodega/getdatos', 'Warehouse\BodegaController@getdatos')->name("bodega.getdatos");
    Route::post('/bodega/setdatos', 'Warehouse\BodegaController@setdatos')->name("bodega.setdatos");
    Route::get('/warehouse/pedidos', 'Warehouse\PedidosController@index')->name("warehouse.pedidos");
    Route::post('/pedidos/getdatos', 'Warehouse\PedidosController@getdatos')->name("pedidos.getdatos");
    Route::post('/pedidos/store', 'Warehouse\PedidosController@store')->name("pedidos.store");
    Route::get('/warehouse/informes', 'Warehouse\InformesController@index')->name("warehouse.informes");
    Route::post('/informes/export', 'Warehouse\InformesController@export')->name("informes.export");
    Route::post('/informes/generar', 'Warehouse\InformesController@generar')->name("informes.generar");
    Route::get('/warehouse/mantenedores', 'Warehouse\MantenedoresController@index')->name("warehouse.mantenedores");
    Route::post('/mantenedores/getdatos', 'Warehouse\MantenedoresController@getdatos')->name("mantenedores.getdatos");
    Route::post('/mantenedores/setdatos', 'Warehouse\MantenedoresController@setdatos')->name("mantenedores.setdatos");
    Route::get('/warehouse/configuraciones', 'Warehouse\ConfiguracionController@index')->name("warehouse.configuraciones");
    Route::post('/configuraciones/setdatos', 'Warehouse\ConfiguracionController@setdatos')->name("configuraciones.setdatos");
    Route::post('/sistema/getdatoswarehouse', 'SistemaController@getdatoswarehouse')->name("sistema.getdatoswarehouse");
    Route::post('/sistema/getdatosoperation', 'SistemaController@getdatosoperation')->name("sistema.getdatosoperation");
    Route::post('/sistema/setdatos', 'SistemaController@setdatos')->name("sistema.setdatos");
    Route::post('/sistema/uploadimage', 'SistemaController@uploadimage')->name("sistema.uploadimage");
    Route::post('/sistema/uploadfile', 'SistemaController@uploadfile')->name("sistema.uploadfile");
    Route::get('/warehouse/ordencompra', 'Warehouse\OrdenCompraController@index')->name("warehouse.ordencompra");
    Route::post('/ordencompra/setdatos', 'Warehouse\OrdenCompraController@setdatos')->name("ordencompra.setdatos");
    Route::post('/ordencompra/getdatos', 'Warehouse\OrdenCompraController@getdatos')->name("ordencompra.getdatos");
    Route::name('imprimir')->get('imprimir/{id}', 'ImpresionController@imprimir');
    Route::name('cajachica')->get('cajachica/{fechai}/{fechaf}', 'ImpresionController@cajachica');

    
});
//Url::forceScheme('https');