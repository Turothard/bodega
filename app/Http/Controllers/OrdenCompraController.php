<?php

namespace App\Http\Controllers;
use App\User;
use App\Marca;
use App\OrdenCompra;
use App\DetalleOrdenCompra;
use App\DocumentoOrdenCompra;
use App\RecepcionOc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenCompraController extends Controller
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
        return view('ordencompra/ordencompra');
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
    public function getdatos(Request $request)
    {
        if($request->ajax()){
            switch ($request->tipo) {
                case 'detalleoc':
                    $arreglo[0] = DetalleOrdenCompra::where("ordencompra_id",$request->oc)->get();
                    $arreglo[1] = DocumentoOrdenCompra::where("nrooc", $request->oc)->get();
                    $arreglo[2] = RecepcionOc::where("nrooc",$request->oc)
                    ->join('detalleordencompras','recepcionocs.detoc_id','=','detalleordencompras.iddetalleoc')
                    ->select('recepcionocs.id','recepcionocs.nrooc','recepcionocs.doc_id','recepcionocs.detoc_id','recepcionocs.cantidaddetoc','recepcionocs.cantidaddococ','recepcionocs.montounitariodetoc','recepcionocs.montototaldococ','recepcionocs.created_at','recepcionocs.updated_at','recepcionocs.deleted_at','detalleordencompras.articulodetoc', 'detalleordencompras.color_id','detalleordencompras.unidad_id','detalleordencompras.marca_id')->get();
                    return $arreglo;
                    break;
                case 'recepcionaroc':
                    $detalleoc = DetalleOrdenCompra::selectRaw("iddetalleoc, ordencompra_id, articulodetoc, codigoart, bodega_id, sector_id, colordetoc, color_id, marca_id, unidad_id, cantidaddetoc,cantidadrecoc, 0 as cantvuerec, montounitariodetoc, montototaldetoc, '' as nrodocvue, '' as iddocvue")->where("ordencompra_id",$request->oc)->get();
                    return $detalleoc;
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            return view('ordencompra.index');
        }
    }
    public function setdatos(Request $request)
    {
        if($request->ajax()){
            switch ($request->tipo) {
                case 'guardaroc':
                    $marcas = $request->marcas;
                    foreach ($marcas as $marca) {
                        $marc = Marca::find($marca["idmarca"]);
                        if($marc==null){
                            $marc = new Marca();
                            $marc->idmarca = $marca["idmarca"];
                            $marc->nombremar = $marca["nombremar"];
                            $marc->save();
                        }
                    }
                    $ocvue = $request->oc;
                    $detocvues= $request->detoc;
                    $oc = OrdenCompra::find($ocvue["nrooc"]);
                    if($oc!=null){
                        return 'EXISTE';
                    }
                    $oc = new OrdenCompra();
                    $oc->nrooc = $ocvue["nrooc"];
                    $oc->categoria_id = $ocvue["categoria_id"];
                    $oc->proveedor_id = $ocvue["proveedor_id"];
                    $oc->fechaoc = $ocvue["fechaoc"];
                    $oc->cantidadoc = $ocvue["cantidadoc"];
                    $oc->montooc = $ocvue["montooc"];
                    $oc->user_id = auth()->id();
                    $oc->estadooc='INGRESADO';
                    $oc->save();
                    time_nanosleep(0, 200000000);
                    foreach ($detocvues as $detocvue) {
                        $det= new DetalleOrdenCompra();
                        $det->ordencompra_id = $oc->nrooc;
                        $det->articulodetoc = $detocvue["articulodetoc"];
                        //$det->codigoart = $detocvue["codigoart"];
                        $det->bodega_id = $detocvue["bodega_id"];
                        $det->sector_id = $detocvue["sector_id"];
                        $det->colordetoc = $detocvue["colordetoc"];
                        $det->color_id = $detocvue["color_id"];
                        $det->marca_id = $detocvue["marca_id"];
                        $det->unidad_id = $detocvue["unidad_id"];
                        $det->cantidaddetoc = $detocvue["cantidaddetoc"];
                        $det->cantidadrecoc=0;
                        $det->montounitariodetoc = $detocvue["montounitariodetoc"];
                        $det->montototaldetoc = $detocvue["montototaldetoc"];
                        $det->save();
                    }
                    return '';
                    break;
                case 'guardarrecepcion':
                    $docs = $request->documentos;
                    $arts= $request->articulos;
                    $oc = OrdenCompra::find($request->oc);
                    foreach ($docs as $doc) {
                        $ddoc = new DocumentoOrdenCompra();
                        $ddoc->nrooc = $request->oc;
                        $ddoc->proveedor_id = $oc->proveedor_id;
                        $ddoc->tipodocumento = $doc["tipodocumento"];
                        $ddoc->nrodocumento = $doc["nrodocumento"];
                        $ddoc->dctofisico = '';
                        $ddoc->user_id= auth()->id();
                        $ddoc->save();
                    }
                    time_nanosleep(0, 200000000);
                    foreach ($arts as $art) {
                        $ar = new RecepcionOc();
                        $ar->nrooc = $request->oc;
                        $detooc = DocumentoOrdenCompra::where(['nrooc' => $request->oc,'nrodocumento' => $art["nrodocvue"]])->first();
                        $ar->doc_id = $detooc->id;
                        $ar->detoc_id = $art["iddetalleoc"];
                        $ar->cantidaddetoc = $art["cantidaddetoc"];
                        $detooc->cantidadrecoc = $detooc->cantidadrecoc + $art["cantvuerec"];
                        $ar->cantidaddococ = $art["cantvuerec"];
                        $ar->montounitariodetoc = $art["montounitariodetoc"];
                        $ar->montototaldococ = $art["cantvuerec"] * $art["montounitariodetoc"];
                        $ar->save();
                    }
                    if($request->porcentaje=='completo'){
                        $oc->estadooc ='RECEPCIONADO';
                        $oc->save();
                    }else{
                        $oc->estadooc ='RECEPCIÓN IMCOMPLETA';
                        $oc->save();
                    }
                break;
                default:
                    # code...
                    break;
            }
        }else{
            return view('ordencompra.index');
        }
    }
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
