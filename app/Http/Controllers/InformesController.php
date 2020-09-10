<?php

namespace App\Http\Controllers;
use App\Exports\InformeStockExport;
use App\Exports\InformeEntArtExport;
use App\Exports\InformeEntColExport;
use App\Exports\InformeStockCriticoExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Area;
use App\Articulo;
use App\Bodega;
use App\Categoria;
use App\Colaboradore;
use App\PedidoPreestabledido;
use App\Estante;
use App\Marca;
use App\PeriodoDevo;
use App\SubCategoria;
use App\Ubicacione;
use App\Sectore;
use App\Unidade;
use App\Pedido;
use App\DetallePedido;
use App\User;
use App\Posicione;
use App\Notificacione;
use App\NotificacionesUser;
use App\Proveedore;
use App\Colore;
use App\OrdenCompra;
use App\DetalleOrdenCompra;
use App\DocumentoOrdenCompra;
use App\DetallePedPosicione;
class InformesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('informes/informe');
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
    public function store(Request $request)
    {
        //
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
    public function generar(Request $request) 
    {   
        $filtros =$request->detalle;
        switch ($request->tipo) {
            case 'informesstock':
                $name ='InformeStock'.date('Ymd_His').'.xlsx';
                Excel::store(new InformeStockExport($filtros["bodega"],$filtros["estante"]), $name, 'informex');
                return $name;
                break;
            case 'informesstockcritico':
                $name ='InformeStockCritico'.date('Ymd_His').'.xlsx';
                Excel::store(new InformeStockCriticoExport($filtros["bodega"],$filtros["estante"]), $name, 'informex');
                return $name;
                break;

            case 'informeentregaarticulos':
                $articulox =array();
                foreach ($filtros["articulos"] as $articulo) {
                   // return $articulo;
                    array_push($articulox, $articulo["codigoart"]);
                }
                if($filtros["subcategoria"]!=''){
                    $detalle = DetallePedPosicione::whereIN("detallepedposiciones.codigoart", $articulox)
                    ->where("detallepedposiciones.updated_at", ">=", $filtros['fechai'])
                    ->where("detallepedposiciones.updated_at", "<=", $filtros['fechaf'])
                    ->where("detallepedposiciones.receptor_prod","<>","''")
                    ->whereNotNull("detallepedposiciones.receptor_prod")
                    ->join("colaboradores", "colaboradores.rutcolaborador", "detallepedposiciones.receptor_prod")
                    ->join("articulos", "articulos.codigoart", "detallepedposiciones.codigoart")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->where("articulos.subcategoria_id","=", $filtros['subcategoria'])
                    ->select("detallepedidos.pedido_id","detallepedposiciones.updated_at","detallepedposiciones.codigoart", 
                    "colaboradores.nombrescolab","colaboradores.apellidoscolab", "colaboradores.nombrecortocolab", "articulos.nombreart",
                    "detallepedposiciones.cantidadproceso","detallepedposiciones.cantidaddevolucion")->orderBy('detallepedposiciones.updated_at', 'desc')->get();
                }else{
                    $detalle = DetallePedPosicione::whereIN("detallepedposiciones.codigoart", $articulox)
                    ->where("detallepedposiciones.updated_at", ">=", $filtros['fechai'])
                    ->where("detallepedposiciones.updated_at", "<=", $filtros['fechaf'])
                    ->where("detallepedposiciones.receptor_prod","<>","''")
                    ->whereNotNull("detallepedposiciones.receptor_prod")
                    ->join("colaboradores", "colaboradores.rutcolaborador", "detallepedposiciones.receptor_prod")
                    ->join("articulos", "articulos.codigoart", "detallepedposiciones.codigoart")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->select("detallepedidos.pedido_id","detallepedposiciones.updated_at","detallepedposiciones.codigoart", 
                    "colaboradores.nombrescolab","colaboradores.apellidoscolab", "colaboradores.nombrecortocolab", "articulos.nombreart",
                    "detallepedposiciones.cantidadproceso","detallepedposiciones.cantidaddevolucion")->orderBy('detallepedposiciones.updated_at', 'desc')->get();
                }
                return $detalle;
                break;
            case 'informeentregacolaborador':
                $nombrex =array();
                foreach ($filtros["nombres"] as $nombre) {
                    array_push($nombrex, $nombre["rutcolaborador"]);
                }
                if($filtros["subcategoria"]!=''){                    
                    $detalle = DetallePedPosicione::whereIN("detallepedposiciones.receptor_prod", $nombrex)
                    ->where("detallepedposiciones.updated_at", ">=", $filtros['fechai'])
                    ->where("detallepedposiciones.updated_at", "<=", $filtros['fechaf'])
                    ->join("colaboradores", "colaboradores.rutcolaborador", "detallepedposiciones.receptor_prod")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->join("articulos", "articulos.codigoart", "detallepedposiciones.codigoart")
                    ->where("articulos.subcategoria_id","=", $filtros['subcategoria'])
                    ->select("detallepedidos.pedido_id","detallepedposiciones.updated_at","detallepedposiciones.codigoart", 
                    "colaboradores.nombrescolab","colaboradores.apellidoscolab", "colaboradores.nombrecortocolab", "articulos.nombreart",
                    "detallepedposiciones.cantidadproceso","detallepedposiciones.cantidaddevolucion")->orderBy('detallepedposiciones.updated_at', 'desc')->get();
                }else{
                    $detalle = DetallePedPosicione::whereIN("detallepedposiciones.receptor_prod", $nombrex)
                    ->where("detallepedposiciones.updated_at", ">=", $filtros['fechai'])
                    ->where("detallepedposiciones.updated_at", "<=", $filtros['fechaf'])
                    ->join("colaboradores", "colaboradores.rutcolaborador", "detallepedposiciones.receptor_prod")
                    ->join("articulos", "articulos.codigoart", "detallepedposiciones.codigoart")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->select("detallepedidos.pedido_id","detallepedposiciones.updated_at","detallepedposiciones.codigoart", 
                    "colaboradores.nombrescolab","colaboradores.apellidoscolab", "colaboradores.nombrecortocolab", "articulos.nombreart",
                    "detallepedposiciones.cantidadproceso","detallepedposiciones.cantidaddevolucion")->orderBy('detallepedposiciones.updated_at', 'desc')->get();
                }
                return $detalle;
                break;
            default:
                # code...
                break;
        }
        
    }
    public function export(Request $request) 
    {   
        $filtros =$request->detalle;
        switch ($request->tipo) {
            case 'informesstock':
                $name ='InformeStock'.date('Ymd_His').'.xlsx';
                Excel::store(new InformeStockExport($filtros["bodega"],$filtros["estante"]), $name, 'informex');
                return $name;
                break;
            case 'informesstockcritico':
                $name ='InformeStockCritico'.date('Ymd_His').'.xlsx';
                Excel::store(new InformeStockCriticoExport($filtros["bodega"],$filtros["estante"]), $name, 'informex');
                return $name;
                break;

            case 'informeentregaarticulos':
                $articulox =array();
                foreach ($filtros["articulos"] as $articulo) {
                   // return $articulo;
                    array_push($articulox, $articulo["codigoart"]);
                }
                if($filtros["subcategoria"]!=''){
                    
                    $detalle = DetallePedPosicione::whereIN("detallepedposiciones.codigoart", $articulox)
                    ->where("detallepedposiciones.updated_at", ">=", $filtros['fechai'])
                    ->where("detallepedposiciones.updated_at", "<=", $filtros['fechaf'])
                    ->where("detallepedposiciones.receptor_prod","<>","''")
                    ->whereNotNull("detallepedposiciones.receptor_prod")
                    ->join("colaboradores", "colaboradores.rutcolaborador", "detallepedposiciones.receptor_prod")
                    ->join("articulos", "articulos.codigoart", "detallepedposiciones.codigoart")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->where("articulos.subcategoria_id","=", $filtros['subcategoria'])
                    ->select("detallepedidos.pedido_id","detallepedposiciones.updated_at","detallepedposiciones.codigoart", 
                    "colaboradores.nombrescolab","colaboradores.apellidoscolab", "colaboradores.nombrecortocolab", "articulos.nombreart",
                    "detallepedposiciones.cantidadproceso","detallepedposiciones.cantidaddevolucion")->orderBy('detallepedposiciones.updated_at', 'desc')->get();
                }else{
                    $detalle = DetallePedPosicione::whereIN("detallepedposiciones.codigoart", $articulox)
                    ->where("detallepedposiciones.updated_at", ">=", $filtros['fechai'])
                    ->where("detallepedposiciones.updated_at", "<=", $filtros['fechaf'])
                    ->where("detallepedposiciones.receptor_prod","<>","''")
                    ->whereNotNull("detallepedposiciones.receptor_prod")
                    ->join("colaboradores", "colaboradores.rutcolaborador", "detallepedposiciones.receptor_prod")
                    ->join("articulos", "articulos.codigoart", "detallepedposiciones.codigoart")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->select("detallepedidos.pedido_id","detallepedposiciones.updated_at","detallepedposiciones.codigoart", 
                    "colaboradores.nombrescolab","colaboradores.apellidoscolab", "colaboradores.nombrecortocolab", "articulos.nombreart",
                    "detallepedposiciones.cantidadproceso","detallepedposiciones.cantidaddevolucion")->orderBy('detallepedposiciones.updated_at', 'desc')->get();
                }
                //return $detalle;
                //return $request->arreglo;
                $name ='InformeEntregaArticulos'.date('Ymd_His').'.xlsx';
                Excel::store(new InformeEntArtExport($detalle, $filtros["articulos"]), $name, 'informex');
                return $name;
                break;
            case 'informeentregacolaborador':
                $nombrex =array();
                foreach ($filtros["nombres"] as $nombre) {
                    array_push($nombrex, $nombre["rutcolaborador"]);
                }
                if($filtros["subcategoria"]!=''){                    
                    $detalle = DetallePedPosicione::whereIN("detallepedposiciones.receptor_prod", $nombrex)
                    ->where("detallepedposiciones.updated_at", ">=", $filtros['fechai'])
                    ->where("detallepedposiciones.updated_at", "<=", $filtros['fechaf'])
                    ->join("colaboradores", "colaboradores.rutcolaborador", "detallepedposiciones.receptor_prod")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->join("articulos", "articulos.codigoart", "detallepedposiciones.codigoart")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->where("articulos.subcategoria_id","=", $filtros['subcategoria'])
                    ->select("detallepedidos.pedido_id","detallepedposiciones.updated_at","detallepedposiciones.codigoart", 
                    "colaboradores.nombrescolab","colaboradores.apellidoscolab", "colaboradores.nombrecortocolab", "articulos.nombreart",
                    "detallepedposiciones.cantidadproceso","detallepedposiciones.cantidaddevolucion")->orderBy('detallepedposiciones.updated_at', 'desc')->get();
                }else{
                    $detalle = DetallePedPosicione::whereIN("detallepedposiciones.receptor_prod", $nombrex)
                    ->where("detallepedposiciones.updated_at", ">=", $filtros['fechai'])
                    ->where("detallepedposiciones.updated_at", "<=", $filtros['fechaf'])
                    ->join("colaboradores", "colaboradores.rutcolaborador", "detallepedposiciones.receptor_prod")
                    ->join("articulos", "articulos.codigoart", "detallepedposiciones.codigoart")
                    ->join("detallepedidos", "detallepedidos.id", "detallepedposiciones.detallepedido_id")
                    ->select("detallepedidos.pedido_id","detallepedposiciones.updated_at","detallepedposiciones.codigoart", 
                    "colaboradores.nombrescolab","colaboradores.apellidoscolab", "colaboradores.nombrecortocolab", "articulos.nombreart",
                    "detallepedposiciones.cantidadproceso","detallepedposiciones.cantidaddevolucion")->orderBy('detallepedposiciones.updated_at', 'desc')->get();
                }
                $name ='InformeEntregaColaboradores'.date('Ymd_His').'.xlsx';
                Excel::store(new InformeEntColExport($detalle, $filtros["nombres"]), $name, 'informex');
                return $name;
                break;
            default:
                # code...
                break;
            }
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
