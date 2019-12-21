<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Articulo;
use App\Bodega;
use App\Categoria;
use App\Colaboradore;
use App\User;
use App\Estante;

use App\PeriodoDevo;
use App\SubCategoria;
use App\Ubicacione;
use App\Sectore;
use App\Unidade;
use App\Pedido;
use App\DetallePedido;
use App\DetallePedPosicione;
use App\Posicione;

class MantenedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mantenedores/mantenedor');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getdatos(Request $request)
    {
        if($request->ajax()){
            switch ($request->tipo) {
                case 'articulos':
                    $articulos = Articulo::where('codigoart','<>',"''")
                    ->join('categorias', 'categorias.idcategoria','=', 'articulos.categoria_id')
                    ->join('subcategorias', 'subcategorias.idsubcategoria','=', 'articulos.subcategoria_id')
                    ->join('unidades', 'unidades.idunidad','=', 'articulos.unidad_id')
                    ->join('colores', 'colores.idcolor','=', 'articulos.color_id')
                    ->join('periodosdevos', 'periodosdevos.idperiodo','=', 'articulos.periododevo_id')
                    ->join('marcas', 'marcas.idmarca','=','articulos.marca_id')
                    ->select('articulos.codigoart','articulos.codigoalternativoart','articulos.categoria_id','categorias.codigocat','categorias.nombrecat',
                    'articulos.subcategoria_id','subcategorias.codigosubcat','subcategorias.nombresubcat','articulos.nombreart','articulos.proveedorart',
                    'articulos.descripcionart','articulos.color_id','colores.nombrecol','articulos.unidad_id','unidades.nombretipounimed','unidades.codigounimed',
                    'unidades.descripcionunimed','articulos.marca_id','marcas.nombremar','articulos.stockcriticoart','articulos.indicerotacionart',
                    'articulos.yearart','articulos.periododevo_id','periodosdevos.periododevo', 'periodosdevos.descripcionper','articulos.image')->get();
                    return $articulos;
                    break;
                
                default:
                    # code...
                    break;
            }
        }else{
            return view('mantenedores.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
