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
use App\PedidoPreestabledido;
use App\PeriodoDevo;
use App\SubCategoria;
use App\Ubicacione;
use App\Sectore;
use App\Unidade;
use App\Pedido;
use App\DetallePedido;
use App\DetallePedPosicione;
use App\Posicione;
use Illuminate\Support\Facades\DB;
class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pedidos/pedido');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdatos(Request $request)
    {
        if($request->ajax()){
            switch ($request->tipo) {
                case 'stockarticulo':
                    $cant =Posicione::where("codigoart",$request->codigo)->sum("cantidadpos");
                    
                    $cant2=Pedido::where('estadoped', 'INGRESADO')->leftJoin('detallepedidos', 'pedidos.id', '=', 'detallepedidos.pedido_id')->select('detallepedidos.cantidaddetped')->where('detallepedidos.codigoart','=',$request->codigo)->sum('cantidaddetped');
                    
                    $cantx = $cant-$cant2;
                   
                    if((int)$request->cantidad>(int)$cantx){
                        $array[0]=0;
                    }else{
                        $array[0]=1;
                    }
                    $array[1]=$cantx;
                    return $array;
                    break;
                case 'detallepedido':
                    $ped = Pedido::find($request->id);
                    
                    if($ped->estadoped=='PENDIENTE' || $ped->estadoped=='ANULADO'){
                        $detped=DetallePedido::where("pedido_id",$request->id)->get();
                        return $detped;
                        
                    }
                    if($ped->estadoped=='PROCESADO' || $ped->estadoped=='ENTREGADO' || $ped->estadoped=='FINALIZADO'){
                        $detped=DetallePedido::where("pedido_id",$request->id)
                        ->join('detallepedposiciones','detallepedidos.id','=','detallepedposiciones.detallepedido_id')
                        ->join('posiciones','detallepedposiciones.posicion_id','=','posiciones.idposicion')
                        ->join('estantes','estantes.id','=','posiciones.estante_id')
                        ->select('estantes.bodega_id','detallepedidos.tipodetped','detallepedidos.pedido_id','identusodetped','obsentped','obsdevodetped','estadodetped','detallepedposiciones.id','detallepedposiciones.detallepedido_id','detallepedposiciones.codigoart','detallepedposiciones.posicion_id','detallepedposiciones.cantidadpedido','detallepedposiciones.cantidadproceso','detallepedposiciones.cantidaddevolucion','detallepedposiciones.receptor_prod',DB::raw("'' as receptor_vue"))->get();
                        return $detped;
                    }
                    if($ped->estadoped=='INGRESADO'){
                        $detped=DetallePedido::where("pedido_id",$request->id)->get(['id','pedido_id','tipodetped','codigoart','cantidaddetped','cantidadprodetped','cantidaddifdetped','identusodetped','obsentped','obsdevodetped','estadodetped', DB::raw("'' as posicion_id, '' as bodega_id,'' as nroestante, '' as sectorpos, '' as nivelpos, '' as receptor_prod")]);
                        
                        $detalle = array();
                        foreach ($detped as $det) {
                            $cantidad=(int)$det->cantidaddetped;
                            //$copiadet = $det;
                            $posis= Posicione::where('codigoart', $det->codigoart)->join('estantes', 'estantes.id','=','posiciones.estante_id')->select('posiciones.idposicion','estantes.bodega_id', 'estantes.nroestante','posiciones.sectorpos','posiciones.nivelpos', 'posiciones.cantidadpos')->orderBy('estantes.bodega_id')->orderBy('posiciones.cantidadpos')->get();
                            //return $posis;
                            foreach ($posis as $posi) {
                                $copiadet = clone ($det);
                                if((int)$posi->cantidadpos>= $cantidad){
                                    //return 'ENTRO AL IF';
                                    $copiadet->bodega_id = $posi->bodega_id;
                                    $copiadet->posicion_id = $posi->idposicion;
                                    $copiadet->nroestante = $posi->nroestante;
                                    $copiadet->sectorpos = $posi->sectorpos;
                                    $copiadet->nivelpos = $posi->nivelpos;
                                    $copiadet->cantidaddetped = $cantidad;
                                    array_push($detalle,$copiadet);
                                    break;
                                }else{
                                    //return 'ENTRO AL else';
                                    $cantidad = (int)$cantidad -(int)$posi->cantidadpos;
                                    $copiadet->bodega_id = $posi->bodega_id;
                                    $copiadet->posicion_id = $posi->idposicion;
                                    $copiadet->nroestante = $posi->nroestante;
                                    $copiadet->sectorpos = $posi->sectorpos;
                                    $copiadet->nivelpos = $posi->nivelpos;
                                    $copiadet->nivelpos = $posi->nivelpos;
                                    $copiadet->cantidaddetped = $posi->cantidadpos;
                                    array_push($detalle,$copiadet);
                                }
                                //return $copiadet;
                                $copiadet=null;
                            }
                        }
                        return $detalle;
                    }
                    
                break;
                default:
                    return null;
                    break;
            }
        }else{
            return view('colaboradores.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            switch ($request->tipo) {
                case 'aceptarpedido':
                    $ped = Pedido::find($request->id);
                    $ped->autorizado_id =User::where("id",auth()->id())->first()->value('rut');
                    $ped->estadoped='INGRESADO';
                    guardarnotificacion(auth()->id(), 'INGRESO','INGRESADO', 'pedidos',$ped,null);
                    $ped->save();
                    return;
                    break;
                case 'guardarpedido':
                    $pedvue=$request->ped;
                    $detpedvue=$request->det;
                    $depto = User::where("id",auth()->id())->value('department');
                    
                    $ped = new Pedido();
                    $ped->tipopedido = 'NORMAL';
                    $ped->user_id =auth()->id();
                    $ped->sector_id = $pedvue['sector'];
                    $ped->area_id = $pedvue['area'];
                    if($pedvue['ubicacion']!=null){
                        $ped->area_id = $pedvue['area'];
                    }

                    $ped->cantidadped = $pedvue['cantidad'];
                    $ped->fechaped = date("Y-m-d");
                    if($depto=='SUPERVISOR' || $depto=='ADMIN'){
                        $ped->estadoped='INGRESADO';
                        $ped->autorizado_id =User::where("id",auth()->id())->first()->value('rut');
                    }else{
                        $ped->estadoped='PENDIENTE';
                    }
                    
                    $ped->save();
                    time_nanosleep(0, 200000000);
                    foreach ($detpedvue as $dped) {
                        //return $dped;
                        $deta= new DetallePedido();
                        $deta->pedido_id = $ped->id;
                        if($dped['tipo']){
                            $deta->tipodetped="INDIVIDUAL";
                        }else{
                            $deta->tipodetped="NORMAL";
                        }
                        $deta->codigoart = $dped["codigoart"];
                        $deta->cantidaddetped = $dped["cantidad"];
                        $deta->save();

                    }
                    if($depto=='SUPERVISOR' || $depto=='ADMIN'){
                        guardarnotificacion(auth()->id(), 'INGRESO','INGRESADO', 'pedidos',$ped,null);
                    }else{
                        guardarnotificacion(auth()->id(), 'INGRESO','PENDIENTE', 'pedidos',$ped,null);
                    }
                    
                    return $ped;
                    break;
                case 'procesarpedido':
                    $ped = Pedido::find($request->id);
                    $detpedvue = $request->detalle;
                    $ped->bodeguero_id =User::where("id",auth()->id())->first()->value('rut');
                    $ped->estadoped='PROCESADO';
                    $cantidad=0;
                    foreach ($detpedvue as $dped) {
                        $posi= Posicione::find($dped['posicion_id']);
                        $posi->cantidadpos = (int)$posi->cantidadpos -(int)$dped['cantidadprodetped'];
                        $cantidad = $cantidad+(int)$dped['cantidadprodetped'];
                        $posi->save();
                        $detalleped= DetallePedido::find($dped['id']);
                        if($detalleped->cantidadprodetped!=null){
                            $detalleped->cantidadprodetped= (int)$detalleped->cantidadprodetped + (int)$dped['cantidadprodetped'];
                        }else{
                            $detalleped->cantidadprodetped=$dped['cantidadprodetped'];
                        }
                        $detalleped->save();                        
                        if($dped['tipodetped']=='NORMAL'){
                            $pedposi = new DetallePedPosicione();
                            $pedposi->detallepedido_id = $dped['id'];
                            $pedposi->codigoart = $dped['codigoart'];
                            $pedposi->posicion_id = $dped['posicion_id'];
                            $pedposi->cantidadpedido = $dped['cantidaddetped'];
                            $pedposi->cantidadproceso = $dped['cantidadprodetped'];
                            $pedposi->save();
                        }else{
                            for ($i=1; $i <((int)$dped['cantidadprodetped']+1) ; $i++) { 
                                $pedposi = new DetallePedPosicione();
                                $pedposi->detallepedido_id = $dped['id'];
                                $pedposi->codigoart = $dped['codigoart'];
                                $pedposi->posicion_id = $dped['posicion_id'];
                                $pedposi->cantidadpedido = 1;
                                $pedposi->cantidadproceso = 1;
                                $pedposi->save();
                            }
                        }
                    }
                    $ped->cantidadproped = $cantidad;
                    $ped->save();
                    guardarnotificacion(auth()->id(), 'ACTUALIZACION','PROCESADO', 'pedidos',$ped,null);
                break;
                case 'entregarpedido':
                    $pedvue = $request->pedido;
                    $ped = Pedido::find($pedvue['id']);
                    $detpedvue = $request->detalle;
                    
                    $flag=true;
                    $detpedvue = $request->detalle;
                    
                    foreach ($detpedvue as $dped) {
                        $detalleped= DetallePedPosicione::find($dped['id']);
                        if($dped['tipodetped']=='INDIVIDUAL'){
                            if($dped['receptor_vue']!=''){
                                $detalleped->receptor_prod = $dped['receptor_vue'];
                            }else{
                                if($detalleped->receptor_prod==null){
                                    $flag=false;
                                }
                            }                                                       
                        }else{
                            if($pedvue['receptor_id']!=''){
                                $detalleped->receptor_prod =$pedvue['receptor_id'];
                            }else{
                                if($detalleped->receptor_prod==null){
                                    $flag=false;
                                }
                            }
                        }
                        $detalleped->save();
                    }

                    if($pedvue['receptor_id']!=''){
                        $ped->receptor_id =$pedvue['receptor_id'];
                    }else{
                        if($ped->receptor_id ==null){
                            $flag=false;
                        }
                        
                    }
                    if($flag){
                        $ped->estadoped='ENTREGADO';
                        
                        $detalleped = DetallePedido::where("ordencompra_id",$pedvue['id']);
                        
                        $flag2=true;
                        foreach ($detalleped as $det) {
                            
                            $periodo =Articulo::find($det->codigoart)->periododevos()->first();
                            if($periodo->periododevo!=0){
                                $flag2=false;
                            }
                        }
                        if($flag2){
                            $ped->estadoped='FINALIZADO';
                            $ped->save();
                            guardarnotificacion(auth()->id(), 'ACTUALIZACION','FINALIZADO', 'pedidos',$ped,null);
                            return  "FINALIZADO";
                            
                        }
                        $ped->save();
                        guardarnotificacion(auth()->id(), 'ACTUALIZACION','ENTREGADO', 'pedidos',$ped,null);
                        return  "ENTREGADO";

                    }else{
                        $ped->save();
                        guardarnotificacion(auth()->id(), 'ACTUALIZACION','ENTREGADO', 'pedidos',$ped,null);
                    }
                   return $flag;
                   
                break;
                default:
                    # code...
                    break;
            }
        }else{
            return view('colaboradores.index');
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
