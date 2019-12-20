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
class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('bodega/bodega');
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
                case 'bodega':
                    $bodega = Posicione::where('cantidadpos','>','0')
                    ->join('estantes', 'estantes.id','=', 'posiciones.estante_id')
                    ->join('articulos', 'articulos.codigoart','=', 'posiciones.codigoart')
                    ->join('periodosdevos', 'periodosdevos.idperiodo','=', 'articulos.periododevo_id')
                    ->select('posiciones.idposicion','estantes.bodega_id', 'posiciones.estante_id', 'estantes.nroestante', 'posiciones.sectorpos', 'posiciones.nivelpos', 'posiciones.codigoart', 
                    'articulos.nombreart', 'posiciones.cantidadpos', 'articulos.stockcriticoart', 'articulos.indicerotacionart', 
                    'periodosdevos.descripcionper')->get();
                    return $bodega;
                    break;
                
                default:
                    # code...
                    break;
            }
        }else{
            return view('bodega.index');
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
