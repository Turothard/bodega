<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Colore;
use App\Articulo;
use App\Bodega;
use App\Categoria;
use App\Colaboradore;
use App\User;
use App\Estante;
use App\Marca;
use App\Proveedore;
use App\PeriodoDevo;
use App\SubCategoria;
use App\Ubicacione;
use App\Sectore;
use App\Unidade;
use App\Pedido;
use App\DetallePedido;
use App\Correlativo;
use App\Posicione;
use Illuminate\Support\Str;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('warehouse/configuracion/configuracion');
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
    public function setdatos(Request $request)
    {
        if($request->ajax()){
            
            switch ($request->tipo) {
                case 'nuevocolaborador':
                    $colvue = $request->detalle;
                    $col= Colaboradore::find($colvue["rutcolaborador"]);
                    if($col!=null){
                        return 1;
                    }
                    $col = Colaboradore::where("nombrecortocolab", $colvue["nombrecortocolab"])->get()->first();
                    if($col!=null){
                        return 2;
                    }
                    $col = new Colaboradore();
                    $col->rutcolaborador=Str::upper($colvue["rutcolaborador"]);
                    $col->nombrescolab=Str::upper($colvue["nombrescolab"]);
                    $col->apellidoscolab=Str::upper($colvue["apellidoscolab"]);
                    $col->nombrecortocolab=Str::upper($colvue["nombrecortocolab"]);
                    $col->deptocolab=Str::upper($colvue["deptocolab"]);
                    $col->sectorcolab=Str::upper($colvue["sectorcolab"]);
                    $col->cargocolab=Str::upper($colvue["cargocolab"]);
                    $col->fechaingresocolab=$colvue["fechaingresocolab"];
                    if($colvue["fechasalidacolab"]!=''){
                        $col->fechasalidacolab=$colvue["fechasalidacolab"];
                    }
                    $col->estadocolab=$colvue["estadocolab"];
                    $col->save();
                    return 0;
                    break;
                case 'editarcolaborador':
                    $colvue = $request->detalle;
                    $col= Colaboradore::find($colvue["rutcolaborador"]);
                    $col->nombrescolab=Str::upper($colvue["nombrescolab"]);
                    $col->apellidoscolab=Str::upper($colvue["apellidoscolab"]);
                    $col->nombrecortocolab=Str::upper($colvue["nombrecortocolab"]);
                    $col->deptocolab=Str::upper($colvue["deptocolab"]);
                    $col->sectorcolab=Str::upper($colvue["sectorcolab"]);
                    $col->cargocolab=Str::upper($colvue["cargocolab"]);
                    $col->fechaingresocolab=$colvue["fechaingresocolab"];
                    if($colvue["fechasalidacolab"]!=''){
                        $col->fechasalidacolab=$colvue["fechasalidacolab"];
                    }
                    $col->estadocolab=$colvue["estadocolab"];
                    $col->save();
                    return 0;
                    break;
                case 'crearusuario':
                    $uservue = $request->detalle;
                    $user = User::where("name", $user["name"])->get()->first();
                    if($user!=null){
                        return 1;
                    }
                    $user = User::where("email", $user["email"])->get()->first();
                    if($user!=null){
                        return 2;
                    }
                    $user = User::where("rut", $user["rut"])->get()->first();
                    if($user!=null){
                        return 3;
                    }
                    $user= new User();
                    $user->name =$user["name"];
                    $user->email =$user["email"];
                    $user->department =$user["department"];
                    $user->password = bcrypt($request->password);
                    
                    $user->save();
                    break;
                case 'editarusuario':
                    
                    $user = User::where("name", $user["name"])->where("rut","<>", $user["rut"])->get()->first();
                    if($user!=null){
                        return 1;
                    }
                    $user = User::where("email", $user["email"])->where("rut","<>", $user["rut"])->get()->first();
                    if($user!=null){
                        return 2;
                    }
                    $user = User::where("rut", $user["rut"])->get()->first();
                    $user->name =$user["name"];
                    $user->email =$user["email"];
                    $user->department =$user["department"];
                    if($request->password!=""){
                        $user->password = bcrypt($request->password);
                    }
                    $user->save();
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            return view('configuraciones.index');
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
