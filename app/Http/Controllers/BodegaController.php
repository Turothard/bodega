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
use App\Ingreso;
use App\PeriodoDevo;
use App\SubCategoria;
use App\Ubicacione;
use App\Sectore;
use App\Unidade;
use App\Movimiento;
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

    public function setdatos(Request $request)
    {
        if($request->ajax()){
            switch ($request->tipo) {
                case 'guardarmovimiento':
                    $origen = $request->origen;
                    $destino = $request->destino;
                    $ori = Posicione::find($origen["idposicion"]);
                    $pos = Posicione::where("codigoart", $origen["codigoart"])
                        ->where("estante_id", $destino["estante_id"])
                        ->where("sectorpos",$destino["sector_id"])
                        ->where("nivelpos", $destino["nivel_id"])->first();
                    $fecha='';
                    if($pos!=null){
                        $pos->cantidadpos = $pos->cantidadpos+ (int)$destino["cantidad"];
                        $ori->cantidadpos = $ori->cantidadpos- (int)$destino["cantidad"];
                        $ori->save();
                        $pos->save();
                        $fecha= $pos->updated_at;
                    }else{
                        $newpos= new Posicione();
                        $newpos->estante_id = $destino["estante_id"];
                        $newpos->sectorpos = $destino["sector_id"];
                        $newpos->nivelpos = $destino["nivel_id"];
                        $newpos->codigoart = $origen["codigoart"];
                        $newpos->cantidadpos = (int)$destino["cantidad"];
                        $newpos->save();
                        $ori->cantidadpos = $ori->cantidadpos- (int)$destino["cantidad"];
                        $ori->save();
                        $fecha= $newpos->updated_at;
                    }
                    $mov = new Movimiento();
                    $mov->codigoart= $origen["codigoart"];
                    $mov->bodegaidori= $origen["bodega_id"];
                    $mov->estanteori= $origen["estante_id"];
                    $mov->sectorori= $origen["sectorpos"];
                    $mov->nivelori= $origen["nivelpos"];
                    $mov->bodegaiddes= $destino["bodega_id"];
                    $mov->estantedes= $destino["estante_id"];
                    $mov->sectordes= $destino["sector_id"];
                    $mov->niveldes= $destino["nivel_id"];
                    $mov->cantidad = (int)$destino["cantidad"];
                    $mov->usermov = User::where("id",auth()->id())->first()->value('rut');
                    $mov->fechamov = $fecha;
                    $mov->save();
                    break;
                case 'ingresararticulos':
                    $detalle= $request->detalle;
                    foreach ($detalle as $det) {
                        $pos = Posicione::where("codigoart", $det["codigoart"])
                        ->where("estante_id", $det["estante_id"])
                        ->where("sectorpos",$det["sector_id"])
                        ->where("nivelpos", $det["nivel_id"])->first();
                        $fecha='';
                        if($pos!=null){
                            $pos->cantidadpos = $pos->cantidadpos+ (int)$det["cantidad"];
                            $pos->save();
                            $fecha= $pos->updated_at;
                        }else{
                            $newpos= new Posicione();
                            $newpos->estante_id = $det["estante_id"];
                            $newpos->sectorpos = $det["sector_id"];
                            $newpos->nivelpos = $det["nivel_id"];
                            $newpos->codigoart = $det["codigoart"];
                            $newpos->cantidadpos = (int)$det["cantidad"];
                            $newpos->save();
                            $fecha= $newpos->updated_at;
                        }
                        $ingreso = new Ingreso();
                        $ingreso->codigoart=$det["codigoart"];
                        $ingreso->bodega_id=$det["bodega_id"];
                        $ingreso->estante_id=$det["estante_id"];
                        $ingreso->sectoring=$det["sector_id"];
                        $ingreso->niveling=$det["nivel_id"];
                        $ingreso->cantidading=(int)$det["cantidad"];
                        $ingreso->usering = User::where("id",auth()->id())->first()->value('rut');
                        $ingreso->save();
                    }
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
