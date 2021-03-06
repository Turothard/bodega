<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
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
use App\Proveedore;
use App\Colore;
use App\OrdenCompra;
use App\DetalleOrdenCompra;
use App\DocumentoOrdenCompra;
use App\DocSustentatorio;
use Illuminate\Support\Facades\DB;
use Image;
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
            $arreglo[1]=Colaboradore::orderBy('nombrecortocolab')->get();
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
                    $arreglo[13]=Posicione::where("cantidadpos",">","0")->join("articulos", "articulos.codigoart", "posiciones.codigoart")->join("estantes", "estantes.id", "posiciones.estante_id")->join("bodegas", "estantes.bodega_id", "bodegas.idbodega")->where("bodegas.tipobod","Principal")->where("bodegas.tipobod","Principal")->select("articulos.codigoart","articulos.nombreart")->groupBy(["articulos.codigoart", "articulos.nombreart"])->get()->sortbyDesc("articulos.nombreart");
                    $arreglo[14]=Colaboradore::where("estadocolab", "true")->get()->sortby("nombrecortocolab");
                    $arreglo[14]=Colaboradore::where("estadocolab", "true")->get()->sortby("nombrecortocolab");
                    $arreglo[15]= Colaboradore::where("estadocolab", "true")->select("sectorcolab")->groupBy("sectorcolab")->get();
                    break;
                case 'notificaciones':
                    $notis = NotificacionesUser::where("user_id",auth()->id())->join('notificaciones', 'notificaciones.id','=','notificacionesuser.notificacion_id')->select('notificacionesuser.id','notificacionesuser.notificacion_id','notificaciones.tipo','notificaciones.tabla','notificaciones.id_tabla','notificaciones.destino','notificaciones.grupo','notificaciones.userproceso_id','notificaciones.userobjetivo_id','notificaciones.grupoobjetivo','notificaciones.mensaje','notificacionesuser.estado')->where("notificacionesuser.estado","<>","LEIDA")->get();
                    
                    return $notis;
                break;
                case 'Bodega':
                    $arreglo[8]=Bodega::all();
                    $arreglo[9]=Estante::all();
                    $arreglo[10]=Posicione::all();
                    $arreglo[11]=User::where("id",auth()->id())->value("department");
                    $arreglo[12]=Proveedore::all();
                break;
                case 'informes':
                    $arreglo[8]=Bodega::all();
                    $arreglo[9]=Estante::all();
                    $arreglo[10]=Posicione::all();
                    $arreglo[11]=User::where("id",auth()->id())->value("department");
                    $arreglo[12]=Proveedore::all();
                break;
                case 'Mantenedores':
                    $arreglo[8]=Proveedore::orderBy('nombreprov')->get();;
                    $arreglo[9]=Colore::all();
                    $arreglo[10]=Unidade::all();
                    $arreglo[11]=Marca::all();
                    $arreglo[12]=PeriodoDevo::all();
                    $arreglo[13]=User::where("id",auth()->id())->value("department");
                    break;
                case 'OrdenCompra':
                    //$arreglo[8]=DB::table('ordencompras')->get();
                    $arreglo[8]=OrdenCompra::all()->sortByDesc('created_at');
                    $arreglo[9]=Proveedore::all();
                    $arreglo[10]=Colore::all();
                    $arreglo[11]=Unidade::all();
                    $arreglo[12]=Marca::all();
                    $arreglo[13]=PeriodoDevo::all();
                    $arreglo[14]=Bodega::all();
                    $arreglo[15]=Estante::all();
                    $arreglo[16]=User::where("id",auth()->id())->value("department");
                    $arreglo[17]=Colaboradore::where("estadocolab", "true")->get()->sortby("nombrecortocolab");
                    $arreglo[18]= Colaboradore::where("estadocolab", "true")->select("sectorcolab")->groupBy("sectorcolab")->get();
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
    public function uploadfile(Request $request) {
        
        $name = $request->input("nombre");
        $sus = DocSustentatorio::where("nrooc",$name)->count();
        if($sus>0){
            $name = $name."_DOC".$sus;
        }else{
            $name = $name."_DOC1";
        }
        $fileName = $name.'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('documents/supportive/'), $fileName);
              
        return response()->json(['success'=>'You have successfully upload file.']);
    }

    public function uploadimage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
        ]);
        
        $image = $request->file('image');
        $name = $request->input("nombre");
        $tipo = $request->input("tipo");
        if($tipo =='actualizarprod'){
            $extension = $image->getClientOriginalExtension(); // Get the extension
        
            $fileName = trim($name). '.' . $extension;
            $path = public_path('images/'.$fileName);
        
            Image::make($image)->save($path);
            $art = Articulo::find($name);
            $art->image = 'images/'.$fileName;
            $art->save();
        }
        if($tipo=='documentooc'){
            
            $extension = $image->getClientOriginalExtension(); // Get the extension
        
            $fileName = trim($name). '.' . $extension;
            $path = public_path('documents/'.$fileName);
            $nombres = explode("_", $name);
            Image::make($image)->save($path);
            $doc = DocumentoOrdenCompra::where("nrooc",$nombres[0])->where("nrodocumento", $nombres[1])->first();
            $doc->dctofisico = 'documents/'.$fileName;
            $doc->save();
            
            
        }
        
    
        //return $data;
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
