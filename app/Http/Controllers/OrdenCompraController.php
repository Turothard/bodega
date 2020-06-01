<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\Categoria;
use App\DetalleInventario;
use App\User;
use App\Marca;
use App\Colore;
use App\Unidade;
use App\Correlativo;
use App\Posicione;
use App\OrdenCompra;
use App\DetalleOrdenCompra;
use App\DocumentoOrdenCompra;
use App\RecepcionOc;
use App\IngresoOrdenCompra;
use App\SubCategoria;
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
                    $arreglo[3]= IngresoOrdenCompra::where("nrooc",$request->oc)
                    ->join('articulos', 'ingresoordencompras.codigoart', '=','articulos.codigoart')
                    ->join("estantes",'ingresoordencompras.estante_id','=', 'estantes.id')
                    ->select('ingresoordencompras.codigoart','ingresoordencompras.bodega_id','ingresoordencompras.estante_id',
                    'ingresoordencompras.sectoring','ingresoordencompras.niveling','ingresoordencompras.cantidading', 
                    'articulos.nombreart','estantes.nroestante')->get();
                    return $arreglo;
                    break;
                case 'detalleocing':
                    $arreglo[0] = DetalleOrdenCompra::where("ordencompra_id",$request->oc)->get();
                    $arreglo[1] = DocumentoOrdenCompra::where("nrooc", $request->oc)->where("estadodococ",null)->get();
                    $arreglo[2] = RecepcionOc::where("nrooc",$request->oc)
                    ->join('detalleordencompras','recepcionocs.detoc_id','=','detalleordencompras.iddetalleoc')
                    ->select('recepcionocs.id','recepcionocs.nrooc','recepcionocs.doc_id','recepcionocs.detoc_id','recepcionocs.cantidaddetoc'
                    ,'recepcionocs.cantidaddococ','recepcionocs.cantidadingoc','recepcionocs.montounitariodetoc','recepcionocs.montototaldococ'
                    ,'recepcionocs.created_at','recepcionocs.updated_at','detalleordencompras.articulodetoc'
                    ,'detalleordencompras.codigoart','detalleordencompras.bodega_id','detalleordencompras.sector_id'
                    ,'detalleordencompras.color_id','detalleordencompras.unidad_id','detalleordencompras.marca_id')->get();
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
                        $articulo= Articulo::find($detocvue["codigoart"]);
                        if($articulo!=null){
                            $det->codigoart = $detocvue["codigoart"];
                        }
                        $det->descripcionart = $detocvue["descripcionart"];
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
                        $docooc = DocumentoOrdenCompra::where(['nrooc' => $request->oc,'nrodocumento' => $art["nrodocvue"]])->first();
                        $detoc = DetalleOrdenCompra::find($art["iddetalleoc"]);
                        $ar->doc_id = $docooc->id;
                        $ar->detoc_id = $art["iddetalleoc"];
                        $ar->cantidaddetoc = $art["cantidaddetoc"];
                        $detoc->cantidadrecoc = (int)$detoc->cantidadrecoc + (int)$art["cantvuerec"];
                        $ar->cantidadingoc=0;
                        $ar->cantidaddococ = $art["cantvuerec"];
                        $ar->montounitariodetoc = $art["montounitariodetoc"];
                        $ar->montototaldococ = $art["cantvuerec"] * $art["montounitariodetoc"];
                        $ar->save();
                        $detoc->save();
                        
                    }
                    $detalleoc = DetalleOrdenCompra::where("ordencompra_id",$oc->nrooc)->get()->sum("cantidaddetoc");
                    $recepcionado = RecepcionOc::where("nrooc",$oc->nrooc)->get()->sum("cantidaddococ");
                    /*if($request->porcentaje=='completo'){
                        $oc->estadooc ='RECEPCIONADO';
                        $oc->save();
                    }else{
                        $oc->estadooc ='RECEPCIÓN IMCOMPLETA';
                        $oc->save();
                    }*/
                    if($detalleoc==$recepcionado){
                        $oc->estadooc ='RECEPCIONADO';
                        $oc->save();
                    }else{
                        $oc->estadooc ='RECEPCIÓN IMCOMPLETA';
                        $oc->save();
                    }
                break;
                case 'guardaringresooc':
                    $dets =$request->detalle;
                    $ocx=null;
                    foreach ($dets as $det) {
                        $detoc= DetalleOrdenCompra::find($det["detoc_id"]);
                        
                        if($ocx==null){
                            $ocx=$det["nrooc"];
                        }
                        //return $detoc;
                        $recep = RecepcionOc::find($det["id"]);
                        if($detoc->codigoart==null){
                            $oc = OrdenCompra::find($det["nrooc"]);
                            $subcat = SubCategoria::find($det["subcategoria"]);
                            $cat = Categoria::find($oc->categoria_id);
                            $correlativo =Correlativo::where("subcategoria_id",$det["subcategoria"])->max("correlativo");
                            $correlativo = "".((int)$correlativo+1);
                            $corre= $correlativo;
                            while(strlen($correlativo)<5){
                                $correlativo ="0".$correlativo;
                            }
                            $cor = new Correlativo();   
                            $cor->subcategoria_id = $subcat->idsubcategoria;
                            $cor->subcategoria = $subcat->codigosubcat;
                            $cor->correlativo = $corre;
                            $cor->correlativofinal = $subcat->codigosubcat.$correlativo;
                            $cor->save();
                            $art = new Articulo();

                            
                            $art->categoria_id = $oc->categoria_id;
                            $art->subcategoria_id = $det["subcategoria"];
                            
                            $art->proveedorart = $oc->proveedor_id;
                            $art->descripcionart = strtoupper($detoc->descripcionart);
                            $art->color_id = $detoc->color_id;
                            $col = Colore::find($detoc->color_id);
                            $uni = Unidade::find($detoc->unidad_id);
                            $art->codigoart = $detoc->marca_id.$subcat->codigosubcat.$correlativo.$col->idcolor.$uni->idunidad;
                            $art->unidad_id = $detoc->unidad_id;
                            $art->marca_id = $detoc->marca_id;
                            $art->nombreart = strtoupper($detoc->articulodetoc." ".$col->nombrecol." ".$uni->codigounimed);
                            switch ($oc->categoria_id) {
                                case '1':
                                    $art->stockcriticoart = '1';
                                    $art->indicerotacionart = '180';
                                    $art->periododevo_id = '1';
                                    break;
                                case '2':
                                    $art->stockcriticoart = '1';
                                    $art->indicerotacionart = '365';
                                    $art->periododevo_id = '6';
                                    break;
                                case '3':
                                    $art->stockcriticoart = '1';
                                    $art->indicerotacionart = '7';
                                    $art->periododevo_id = '0';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            
                            $art->yearart = date("Y");
                            
                            $art->save();
                            $detoc->codigoart= $art->codigoart;
                            $detoc->save();
                        }
                        $ddoc = new IngresoOrdenCompra();
                        $ddoc->nrooc = $det["nrooc"];
                        $ddoc->recep_id  = $det["id"];
                        $ddoc->cantidadrecep = $det["cantidadingoc"];
                        $ddoc->bodega_id = $det["bodega_id"];
                        $ddoc->codigoart = $detoc->codigoart ;
                        $ddoc->estante_id = $det["estante_id"];
                        $ddoc->sectoring = $det["sector_id"];
                        $ddoc->niveling = $det["nivel_id"];
                        $ddoc->cantidading = $det["cantidading"];
                        $ddoc->usering= auth()->id();
                        $ddoc->save();
                        $recep->cantidadingoc = (int)$recep->cantidadingoc + (int)$det["cantidading"];
                        $recep->save();
                        $posi = Posicione::where("estante_id",$det["estante_id"])->where("sectorpos",$det["sector_id"])
                        ->where("nivelpos",$det["nivel_id"])->where("codigoart",$ddoc->codigoart)->get()->first();
                        if($posi!=null){
                            $posi->cantidadpos= $posi->cantidadpos + $det["cantidading"];
                            $posi->save();
                        }else{
                            $pos = new Posicione();
                            $pos->estante_id = $det["estante_id"];
                            $pos->sectorpos = $det["sector_id"];
                            $pos->nivelpos = $det["nivel_id"];
                            $pos->codigoart = $ddoc->codigoart;
                            $pos->cantidadpos = $det["cantidading"];
                            $pos->save();
                        }
                    }
                    $oc = OrdenCompra::find($ocx);
                    if($oc->estadooc=="RECEPCIONADO"){
                        $recepcionado = RecepcionOc::where("nrooc",$oc->nrooc)->get()->sum("cantidaddococ");
                        $ingresado = RecepcionOc::where("nrooc",$oc->nrooc)->get()->sum("cantidadingoc");
                        if($recepcionado==$ingresado){
                            $oc->estadooc='FINALIZADO';
                            $oc->save();
                        }
                        
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
