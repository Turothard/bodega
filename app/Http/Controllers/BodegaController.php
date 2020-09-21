<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Articulo;
use App\Bodega;
use App\Categoria;
use App\Colaboradore;
use App\User;
use App\IngresoCaja;
use App\Proveedore;
use App\IngresoCajaDetalle;
use App\Estante;
use App\Ingreso;
use App\PeriodoDevo;
use App\SubCategoria;
use App\Ubicacione;
use App\Sectore;
use App\Unidade;
use App\Movimiento;
use App\DetallePedido;
use App\Inventario;
use App\DetalleInventario;
use App\Posicione;
use Illuminate\Support\Facades\DB;
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
                    'periodosdevos.descripcionper')
                    ->orderBy("estantes.bodega_id","ASC")->orderBy("estantes.nroestante","ASC")
                        ->orderBy("posiciones.sectorpos","ASC")->orderBy("posiciones.nivelpos","ASC")->get();
                    return $bodega;
                    break;
                case 'ingresos':
                    $ingresos[0]= Ingreso::where('cantidading','>','0')
                    ->join('estantes', 'estantes.id','=', 'ingresos.estante_id')
                    ->join('posiciones', 'posiciones.idposicion','=', 'ingresos.posicion_id')
                    ->join('articulos', 'articulos.codigoart','=', 'ingresos.codigoart')
                    ->join('colaboradores', 'colaboradores.rutcolaborador','=', 'ingresos.usering')
                    ->select('ingresos.id','ingresos.codigoart', 'articulos.nombreart', 'ingresos.bodega_id', 'ingresos.estante_id', 'estantes.nroestante', 'ingresos.sectoring', 'ingresos.niveling',
                     'ingresos.usering', 'colaboradores.nombrecortocolab', 'ingresos.cantidading','ingresos.posicion_id','ingresos.fechaing', 'ingresos.created_at','posiciones.updated_at')->get();
                     $ingresos[1] = IngresoCaja::where('cantidading','>','0')
                     ->join('colaboradores', 'colaboradores.rutcolaborador','=', 'ingresoscaja.usering')
                     ->select('ingresoscaja.id','ingresoscaja.proveedor_id', 'ingresoscaja.usering','colaboradores.nombrecortocolab', 'ingresoscaja.nombreproving',
                      'ingresoscaja.tipodocing', 'ingresoscaja.nrodocing','ingresoscaja.cantidading', 'ingresoscaja.montoing','ingresoscaja.fechaingresoing', 
                      'ingresoscaja.created_at','ingresoscaja.updated_at')->get();
                     return $ingresos;
                break;
                case 'detallecompracaja':
                    $detalle = IngresoCajaDetalle::where('ingresocaja_id','=',$request->detalle)
                    ->join('estantes', 'estantes.id','=', 'ingresoscajadetalle.estante_id')
                    ->join('posiciones', 'posiciones.idposicion','=', 'ingresoscajadetalle.posicion_id')
                    ->join('articulos', 'articulos.codigoart','=', 'ingresoscajadetalle.codigoart')
                    ->select('ingresoscajadetalle.id','ingresoscajadetalle.codigoart', 'articulos.nombreart', 'ingresoscajadetalle.bodega_id', 'ingresoscajadetalle.estante_id', 
                    'estantes.nroestante', 'ingresoscajadetalle.sectoring', 'ingresoscajadetalle.niveling', 'ingresoscajadetalle.cantidading', 'ingresoscajadetalle.precioing', 
                    'ingresoscajadetalle.totaling','ingresoscajadetalle.posicion_id','ingresoscajadetalle.fechaing', 'ingresoscajadetalle.created_at','posiciones.updated_at')->get();
                    return $detalle;
                break;
                case 'movimientos':
                    $movi = Movimiento::where("cantidad",">","0")
                    ->join('posiciones', 'posiciones.idposicion','=', 'movimientos.posiciondes_id')
                    ->join('articulos', 'articulos.codigoart','=', 'movimientos.codigoart')
                    ->join('colaboradores', 'colaboradores.rutcolaborador','=', 'movimientos.usermov')
                    ->select('movimientos.id', 'movimientos.codigoart', 'articulos.nombreart', 'movimientos.bodegaidori', 'movimientos.estanteori', 
                    'movimientos.sectorori','movimientos.nivelori', 'movimientos.posicionori_id', 'movimientos.bodegaiddes', 'movimientos.estantedes', 
                    'movimientos.sectordes','movimientos.niveldes', 'movimientos.posiciondes_id', 'movimientos.cantidad', 'movimientos.usermov',
                    'colaboradores.nombrecortocolab', 'movimientos.fechamov', 'posiciones.updated_at')->get();
                    return $movi;
                break;
                case 'generarinventario':
                    $inv = null;
                    $inventario = Inventario::where("estadoinv","PROCESO")->get();
                    if($inventario->count()>0){
                        return $inv;
                    }
                    if($request->detalle["tipoinv"]=='BODEGA COMPLETA'){
                        $inv = Bodega::where("idbodega",$request->detalle["bodega_id"])
                        ->join('estantes', 'estantes.bodega_id','=', 'bodegas.idbodega')
                        ->join('posiciones', 'posiciones.estante_id','=', 'estantes.id')
                        ->join('articulos', 'articulos.codigoart','=', 'posiciones.codigoart')
                        ->select('estantes.nroestante',DB::raw("bodegas.idbodega as bodega_id, bodegas.nombrebod, posiciones.estante_id, 
                        posiciones.idposicion as posicion_id, posiciones.sectorpos as sectorinv, posiciones.nivelpos as nivelinv, 
                        posiciones.codigoart, articulos.nombreart,posiciones.cantidadpos as cantidadbod,0 as cantidadinv, posiciones.cantidadpos as cantidaddif"))
                        ->where("posiciones.cantidadpos",">","0")
                        ->orderBy("bodegas.idbodega","ASC")->orderBy("estantes.nroestante","ASC")
                        ->orderBy("posiciones.sectorpos","ASC")->orderBy("posiciones.nivelpos","ASC")->get();
                    }else{
                        $inv =Bodega::where("idbodega",$request->detalle["bodega_id"])
                        ->join('estantes', 'estantes.bodega_id','=', 'bodegas.idbodega')
                        ->join('posiciones', 'posiciones.estante_id','=', 'estantes.id')
                        ->join('articulos', 'articulos.codigoart','=', 'posiciones.codigoart')
                        ->select('estantes.nroestante',DB::raw("bodegas.idbodega as bodega_id, bodegas.nombrebod, posiciones.estante_id, 
                         posiciones.idposicion as posicion_id, posiciones.sectorpos as sectorinv, posiciones.nivelpos as nivelinv, 
                         posiciones.codigoart, articulos.nombreart,posiciones.cantidadpos as cantidadbod,0 as cantidadinv, posiciones.cantidadpos as cantidaddif"))
                        ->where("estantes.id",$request->detalle["estante_id"])
                        ->where("posiciones.cantidadpos",">","0")
                        ->orderBy("bodegas.idbodega","ASC")->orderBy("estantes.nroestante","ASC")
                        ->orderBy("posiciones.sectorpos","ASC")->orderBy("posiciones.nivelpos","ASC")->get();
                    }
                    return $inv;
                break;
                case 'inventariosajuste':
                    $inventario = Inventario::find($request->detalle);
                    $arreglo[0] = DetalleInventario::where("inventario_id", $inventario->id)
                    ->join('estantes', 'estantes.id','=', 'detalleinventarios.estante_id')
                    ->join('articulos', 'articulos.codigoart','=', 'detalleinventarios.codigoart')
                    ->select('detalleinventarios.id', 'detalleinventarios.inventario_id', 'detalleinventarios.bodega_id', 'detalleinventarios.posicion_id', 
                    'detalleinventarios.estante_id', 'estantes.nroestante','detalleinventarios.sectorinv', 'detalleinventarios.nivelinv', 
                    'detalleinventarios.codigoart', 'articulos.nombreart', 'detalleinventarios.cantidadbod', 'detalleinventarios.cantidadinv', 'detalleinventarios.cantidaddif')
                    ->orderBy("detalleinventarios.bodega_id","ASC")
                    ->orderBy("estantes.nroestante","ASC")
                    ->orderBy("detalleinventarios.sectorinv","ASC")
                    ->orderBy("detalleinventarios.nivelinv","ASC")->get();
                    return $arreglo;  
                break;
                case 'inventarios':
                    if($request->detalle!=null){
                        $inventario = Inventario::find($request->detalle);
                        $arreglo[0] = DetalleInventario::where("inventario_id", $inventario->id)
                        ->join('estantes', 'estantes.id','=', 'detalleinventarios.estante_id')
                        ->join('articulos', 'articulos.codigoart','=', 'detalleinventarios.codigoart')
                        ->select('detalleinventarios.id', 'detalleinventarios.inventario_id', 'detalleinventarios.bodega_id', 'detalleinventarios.posicion_id', 
                        'detalleinventarios.estante_id', 'estantes.nroestante','detalleinventarios.sectorinv', 'detalleinventarios.nivelinv', 
                        'detalleinventarios.codigoart', 'articulos.nombreart', 'detalleinventarios.cantidadbod', 'detalleinventarios.cantidadinv', 'detalleinventarios.cantidaddif')
                        ->orderBy("detalleinventarios.bodega_id","ASC")
                        ->orderBy("estantes.nroestante","ASC")
                        ->orderBy("detalleinventarios.sectorinv","ASC")
                        ->orderBy("detalleinventarios.nivelinv","ASC")->get();
                        
                    }else{
                        $arreglo[0] =Inventario::where("estadoinv","<>","PROCESO")
                        ->join('colaboradores', 'colaboradores.rutcolaborador','=', 'inventarios.userinv')
                        ->select( 'inventarios.id', 'inventarios.tipoinv', 'inventarios.bodega_id', 'inventarios.estante_id', 'inventarios.fechainv', 
                        'inventarios.userinv','colaboradores.nombrecortocolab', 'inventarios.fechainicioinv', 'inventarios.fechafininv', 
                        'inventarios.cantidadbodtotal', 'inventarios.cantidadinvtotal', 'inventarios.cantidaddiftotal', 'inventarios.observacioninv', 
                        'inventarios.estadoinv', 'inventarios.created_at', 'inventarios.updated_at', 'inventarios.deleted_at')->orderBy("inventarios.created_at","DESC")->get();
                        $inventario = Inventario::where("estadoinv","PROCESO")->first();
                        if($inventario!=null){
                            $arreglo[1] = $inventario;
                            $arreglo[2] = DetalleInventario::where("inventario_id", $inventario->id)
                            ->join('estantes', 'estantes.id','=', 'detalleinventarios.estante_id')
                            ->join('articulos', 'articulos.codigoart','=', 'detalleinventarios.codigoart')
                            ->select('detalleinventarios.id', 'detalleinventarios.inventario_id', 'detalleinventarios.bodega_id', 'detalleinventarios.posicion_id', 
                            'detalleinventarios.estante_id', 'estantes.nroestante','detalleinventarios.sectorinv', 'detalleinventarios.nivelinv', 
                            'detalleinventarios.codigoart', 'articulos.nombreart', 'detalleinventarios.cantidadbod', 'detalleinventarios.cantidadinv', 'detalleinventarios.cantidaddif')
                            ->orderBy("detalleinventarios.bodega_id","ASC")
                            ->orderBy("estantes.nroestante","ASC")
                            ->orderBy("detalleinventarios.sectorinv","ASC")
                            ->orderBy("detalleinventarios.nivelinv","ASC")->get();
                        }else{
                            $arreglo[1] = null;
                            $arreglo[2] = null;
                        }
                    }
                    return $arreglo;
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
                        ->where("nivelpos", $destino["nivel_id"])->get()->first();
                    $fecha='';
                    $posicionori_id='';
                    $posiciondes_id='';
                    if($pos!=null){
                        $pos->cantidadpos = $pos->cantidadpos+ (int)$destino["cantidad"];
                        $ori->cantidadpos = $ori->cantidadpos- (int)$destino["cantidad"];
                        $ori->save();
                        $pos->save();
                        $fecha= $pos->updated_at;
                        $posicionori_id = $ori->idposicion;
                        $posiciondes_id = $pos->idposicion;
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
                        $posicionori_id = $ori->idposicion;
                        $posiciondes_id = $newpos->idposicion;
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
                    $mov->usermov = User::where("id",auth()->id())->value('rut');
                    $mov->posicionori_id =$posicionori_id;
                    $mov->posiciondes_id =$posiciondes_id;
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
                        $id='';
                        if($pos!=null){
                            $pos->cantidadpos = $pos->cantidadpos+ (int)$det["cantidad"];
                            $pos->save();
                            $fecha= $pos->updated_at;
                            $id = $pos->idposicion;
                        }else{
                            $newpos= new Posicione();
                            $newpos->estante_id = $det["estante_id"];
                            $newpos->sectorpos = $det["sector_id"];
                            $newpos->nivelpos = $det["nivel_id"];
                            $newpos->codigoart = $det["codigoart"];
                            $newpos->cantidadpos = (int)$det["cantidad"];
                            $newpos->save();
                            $fecha= $newpos->updated_at;
                            $id = $newpos->idposicion;
                        }
                        $ingreso = new Ingreso();
                        $ingreso->codigoart=$det["codigoart"];
                        $ingreso->bodega_id=$det["bodega_id"];
                        $ingreso->estante_id=$det["estante_id"];
                        $ingreso->sectoring=$det["sector_id"];
                        $ingreso->niveling=$det["nivel_id"];
                        $ingreso->cantidading=(int)$det["cantidad"];
                        $ingreso->fechaing = $fecha;
                        $ingreso->posicion_id = $id;
                        $ingreso->usering = User::where("id",auth()->id())->value('rut');
                        $ingreso->save();
                    }
                    break;
                case 'ingresararticuloscaja':
                    $doc= $request->detalle[0];
                    
                    $detalle= $request->detalle[1];
                    //return $detalle;
                    $ingresodoc = new IngresoCaja();
                    $prov = Proveedore::where("rutproveedor", $doc["rutproveedor"])->get()->first();
                    if($prov==null){
                        $prov = new Proveedore();
                        $prov->rutproveedor = strtoupper($doc["rutproveedor"]);
                        $prov->nombreprov = strtoupper($doc["nombreprov"]);
                        $prov->codigoprov= (string)(1+(int)Proveedore::max("codigoprov"));
                        $prov->save();
                    }
                    $ingresodoc->proveedor_id= $prov->rutproveedor;
                    $ingresodoc->usering = User::where("id",auth()->id())->value('rut');
                    $ingresodoc->nombreproving=$prov->nombreprov;
                    $ingresodoc->tipodocing=$doc["tipodoc"];
                    $ingresodoc->nrodocing=$doc["doc"];
                    $ingresodoc->fechaingresoing=date("Y-m-d");
                    $ingresodoc->cantidading=$doc["cantidad"];
                    $ingresodoc->montoing=ceil($doc["monto"]);
                    $ingresodoc->save();

                    foreach ($detalle as $det) {
                        $pos = Posicione::where("codigoart", $det["codigoart"])
                        ->where("estante_id", $det["estante_id"])
                        ->where("sectorpos",$det["sector_id"])
                        ->where("nivelpos", $det["nivel_id"])->first();
                        $fecha='';
                        $id='';
                        if($pos!=null){
                            $pos->cantidadpos = $pos->cantidadpos+ (int)$det["cantidad"];
                            $pos->save();
                            $fecha= $pos->updated_at;
                            $id = $pos->idposicion;
                        }else{
                            $newpos= new Posicione();
                            $newpos->estante_id = $det["estante_id"];
                            $newpos->sectorpos = $det["sector_id"];
                            $newpos->nivelpos = $det["nivel_id"];
                            $newpos->codigoart = $det["codigoart"];
                            $newpos->cantidadpos = (int)$det["cantidad"];
                            $newpos->save();
                            $fecha= $newpos->updated_at;
                            $id = $newpos->idposicion;
                        }
                        $ingreso = new IngresoCajaDetalle();
                        $ingreso->codigoart=$det["codigoart"];
                        $ingreso->ingresocaja_id = $ingresodoc->id;
                        $ingreso->bodega_id=$det["bodega_id"];
                        $ingreso->estante_id=$det["estante_id"];
                        $ingreso->sectoring=$det["sector_id"];
                        $ingreso->niveling=$det["nivel_id"];
                        $ingreso->cantidading=(int)$det["cantidad"];
                        $ingreso->precioing=(int)$det["precio"];
                        $ingreso->totaling=(int)$det["cantidad"]*(int)$det["precio"];
                        $ingreso->fechaing = $fecha;
                        $ingreso->posicion_id = $id;
                        //$ingreso->usering = User::where("id",auth()->id())->value('rut');
                        $ingreso->save();
                    }
                break;
                case 'revertiringreso':
                    $ingreso = Ingreso::find($request->detalle["id"]);
                    $posicion = Posicione::find($request->detalle["posicion_id"]);
                    $posicion->cantidadpos = $posicion->cantidadpos-$ingreso->cantidading;
                    $ingreso->delete();
                    $posicion->save();
                    return;
                    break;
                case 'revertirmovimiento':
                    $movimiento = Movimiento::find($request->detalle["id"]);
                    $posicionori = Posicione::find($request->detalle["posicionori_id"]);
                    $posiciondes = Posicione::find($request->detalle["posiciondes_id"]);
                    $posicionori->cantidadpos = $posicionori->cantidadpos+$movimiento->cantidad;
                    $posiciondes->cantidadpos = $posiciondes->cantidadpos-$movimiento->cantidad;
                    $movimiento->delete();
                    $posicionori->save();
                    $posiciondes->save();
                    return;
                    break;
                case 'guardaravance':
                    $invvue =$request->inventario;
                    $detinvvue =$request->detalle;
                    $inv = Inventario::where("estadoinv","PROCESO")->first();
                    if($inv!=null){
                        $inv->cantidadbodtotal = $invvue["cantidadbodtotal"];
                        $inv->cantidadinvtotal = $invvue["cantidadinvtotal"];
                        $inv->cantidaddiftotal = $invvue["cantidaddiftotal"];
                        $inv->save();
                        time_nanosleep(0, 200000000);
                        foreach ($detinvvue as $det) {
                            $detinv= DetalleInventario::find($det["id"]);
                            $detinv->cantidadbod = $det["cantidadbod"];
                            $detinv->cantidadinv = $det["cantidadinv"];
                            $detinv->cantidaddif = $det["cantidadbod"]- $det["cantidadinv"];
                            $detinv->save();
                        }
                        guardarnotificacion(auth()->id(), 'ACTUALIZACION','ACTUALIZACION', 'inventarios',$inv,null);
                        return $inv->id;
                    }else{
                        
                        $inv = new Inventario();
                        $inv->tipoinv = $invvue["tipoinv"];
                        $inv->bodega_id = $invvue["bodega_id"];
                        $inv->estante_id = $invvue["estante_id"];
                        $inv->fechainv = date("Y-m-d");
                        $inv->cantidadbodtotal = $invvue["cantidadbodtotal"];
                        $inv->cantidadinvtotal = $invvue["cantidadinvtotal"];
                        $inv->cantidaddiftotal = $invvue["cantidaddiftotal"];
                        $inv->userinv = User::where("id",auth()->id())->value('rut');
                        $inv->estadoinv = 'PROCESO';
                        $inv->fechainicioinv = date("Y-m-d H:i:s");
                        $inv->save();
                        time_nanosleep(0, 200000000);
                        foreach ($detinvvue as $det) {
                            $detinv= new DetalleInventario();
                            $detinv->inventario_id =$inv->id;
                            $detinv->bodega_id = $det["bodega_id"];
                            $detinv->estante_id = $det["estante_id"];
                            $detinv->posicion_id = $det["posicion_id"];
                            $detinv->sectorinv = $det["sectorinv"];
                            $detinv->nivelinv = $det["nivelinv"];
                            $detinv->codigoart = $det["codigoart"];
                            $detinv->cantidadbod = $det["cantidadbod"];
                            $detinv->cantidadinv = $det["cantidadinv"];
                            $detinv->cantidaddif = $det["cantidadbod"]- $det["cantidadinv"];
                            $detinv->save();
                        }
                        guardarnotificacion(auth()->id(), 'INGRESO','INGRESADO', 'inventarios',$inv,null);
                        return $inv->id;
                    }
                    
                break;
                case 'finalizarinventario':
                    $invvue =$request->inventario;
                    $detinvvue =$request->detalle;
                    $inv = Inventario::where("estadoinv","PROCESO")->first();
                    if($inv!=null){
                        $inv->estadoinv = 'FINALIZADO';
                        $inv->fechafininv = date("Y-m-d H:i:s");
                        $inv->cantidadbodtotal = $invvue["cantidadbodtotal"];
                        $inv->cantidadinvtotal = $invvue["cantidadinvtotal"];
                        $inv->cantidaddiftotal = $invvue["cantidaddiftotal"];
                        $inv->save();
                        time_nanosleep(0, 200000000);
                        foreach ($detinvvue as $det) {
                            $detinv= DetalleInventario::find($det["id"]);
                            $detinv->cantidadbod = $det["cantidadbod"];
                            $detinv->cantidadinv = $det["cantidadinv"];
                            $detinv->cantidaddif = $det["cantidadbod"]- $det["cantidadinv"];
                            $detinv->save();
                        }
                        guardarnotificacion(auth()->id(), 'FINALIZADO','FINALIZADO', 'inventarios',$inv,null);
                    }
                break;
                case 'ajustarinventario':
                    $inventario = Inventario::find($request->detalle);
                    $detalles = DetalleInventario::where("inventario_id", $inventario->id)->get();
                   foreach ($detalles as $value) {
                    $posicion = Posicione::where("idposicion", $value->posicion_id)->where("codigoart", $value->codigoart)->get()->first();
                    $posicion->cantidadpos = $value->cantidadinv;
                    $posicion->save();
                    
                   }
                   $inventario->estadoinv='AJUSTADO';
                   $inventario->save();
                   return 0;
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
