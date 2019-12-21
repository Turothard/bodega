<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class SistemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $arreglo[0]=User::all();
            $arreglo[1]=Colaboradore::all();
            $arreglo[2]=Categoria::all();
            $arreglo[3]=SubCategoria::all();
            $arreglo[4]=Articulo::all();
            $arreglo[5]=Sectore::all();
            $arreglo[6]=Area::all();
            $arreglo[7]=Ubicacione::all();
           
            switch ($request->tipo) {
                case 'Pedido':
                    $arreglo[8]=Pedido::all()->sortByDesc('id');
                    $arreglo[9]=Pedido::latest()->value('id');
                    $arreglo[10]=PedidoPreestabledido::all();
                    $arreglo[11]=User::where("id",auth()->id())->value("department");
                    $arreglo[12]=PeriodoDevo::all();
                    break;
                case 'notificaciones':
                    $notis = NotificacionesUser::where("user_id",auth()->id())->join('notificaciones', 'notificaciones.id','=','notificacionesuser.notificacion_id')->select('notificacionesuser.id','notificacionesuser.notificacion_id','notificaciones.tipo','notificaciones.tabla','notificaciones.id_tabla','notificaciones.destino','notificaciones.grupo','notificaciones.userproceso_id','notificaciones.userobjetivo_id','notificaciones.grupoobjetivo','notificaciones.mensaje','notificacionesuser.estado')->where("notificacionesuser.estado","<>","LEIDA")->get();
                    
                    return $notis;
                case 'Bodega':
                    $arreglo[8]=Bodega::all();
                    $arreglo[9]=Estante::all();
                    //$arreglo[10]=Posicione::all();
                    break;
                default:
                    # code...
                    break;
            }
            return $arreglo;
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
    public function setdatos(Request $request)
    {
        if($request->ajax()){
            switch ($request->tipo) {
                case 'notificacionesenviadas':
                    if((int)$request->cant==1){
                        $notuser = NotificacionesUser::find($request->notis['id']);
                        $notuser->estado='ENVIADA';
                        $notuser->save();
                    }else{
                        foreach ($request->notis as $noti) {
                            $notuser = NotificacionesUser::find($noti['id']);
                            $notuser->estado='ENVIADA';
                            $notuser->save();
                        }
                    }
                    
                    break;
                case 'notificacionleida':
                    if((int)$request->cant==1){
                        $notuser = NotificacionesUser::find($request->notis['id']);
                            $notuser->estado='LEIDA';
                            $notuser->save();
                    }else{
                        foreach ($request->notis as $noti) {
                            $notuser = NotificacionesUser::find($noti['id']);
                            $notuser->estado='LEIDA';
                            $notuser->save();
                        }
                    }
                    
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            return;
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
