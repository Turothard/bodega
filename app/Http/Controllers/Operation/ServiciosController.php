<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agencia;
use App\Area;
use App\Sector;
use App\Colaboradore;
use App\DetalleServicio;
use App\DetalleTrabajo;
use App\DetalleTrabajoCampo;
use App\Tarifario;
use App\ColaboradorTrabajo;


class ServiciosController extends Controller
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
        return view('operation/servicios/servicio');
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

    public function getdatos(Request $request)
    {
        if($request->ajax()){
            $dato=null;
            $filtros = $request->filtros;
            switch ($request->tipo) {
                case 'servicios':
                    if($request->valor!=""){
                        if($filtros["fechai"]!="" || $filtros["fechaf"]!="" || $filtros["estado"]!=""){
                            if($filtros["fechai"]!="" && $filtros["fechaf"]!="" && $filtros["estado"]!=""){
                                $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                ->join("areas","idarea","detalleservicios.area_id")
                                ->where("areas.sector_id", $request->valor)
                                ->where("detalleservicios.inicio", ">=", $filtros["fechai"])
                                ->where("detalleservicios.inicio", "<=", $filtros["fechaf"])
                                ->where("detalleservicios.estado", $filtros["estado"])->get();
                            }else{
                                if($filtros["fechai"]!="" && $filtros["fechaf"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->join("areas","idarea","detalleservicios.area_id")
                                    ->where("areas.sector_id", $request->valor)
                                    ->where("detalleservicios.inicio", ">=", $filtros["fechai"])
                                    ->where("detalleservicios.inicio", "<=", $filtros["fechaf"])->get();
                                }
                                if($filtros["fechai"]!="" && $filtros["estado"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->join("areas","idarea","detalleservicios.area_id")
                                    ->where("areas.sector_id", $request->valor)
                                    ->where("detalleservicios.inicio", ">=", $filtros["fechai"])
                                    ->where("detalleservicios.estado", $filtros["estado"])->get();
                                }
                                if($filtros["fechaf"]!="" && $filtros["estado"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->join("areas","idarea","detalleservicios.area_id")
                                    ->where("areas.sector_id", $request->valor)
                                    ->where("detalleservicios.inicio", "<=", $filtros["fechaf"])
                                    ->where("detalleservicios.estado", $filtros["estado"])->get();
                                }
                                if($filtros["fechai"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->join("areas","idarea","detalleservicios.area_id")
                                    ->where("areas.sector_id", $request->valor)
                                    ->where("detalleservicios.inicio", ">=", $filtros["fechaf"])->get();
                                }
                                if($filtros["fechaf"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->join("areas","idarea","detalleservicios.area_id")
                                    ->where("areas.sector_id", $request->valor)
                                    ->where("detalleservicios.inicio", "<=", $filtros["fechaf"])->get();
                                }
                                if($filtros["estado"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->join("areas","idarea","detalleservicios.area_id")
                                    ->where("areas.sector_id", $request->valor)
                                    ->where("detalleservicios.estado", $filtros["estado"])->get();
                                }
                            }
                        }else{
                            
                            $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                            ->join("areas","idarea","detalleservicios.area_id")->where("areas.sector_id", $request->valor)->get();
                        }
                        
                    }else{
                        if($filtros["fechai"]!="" || $filtros["fechaf"]!="" || $filtros["estado"]!=""){
                            if($filtros["fechai"]!="" && $filtros["fechaf"]!="" && $filtros["estado"]!=""){
                                $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                ->where("detalleservicios.inicio", ">=", $filtros["fechai"])
                                ->where("detalleservicios.inicio", "<=", $filtros["fechaf"])
                                ->where("detalleservicios.estado", $filtros["estado"])->get();
                            }else{
                                if($filtros["fechai"]!="" && $filtros["fechaf"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->where("detalleservicios.inicio", ">=", $filtros["fechai"])
                                    ->where("detalleservicios.inicio", "<=", $filtros["fechaf"])->get();
                                }
                                if($filtros["fechai"]!="" && $filtros["estado"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->where("detalleservicios.inicio", ">=", $filtros["fechai"])
                                    ->where("detalleservicios.estado", $filtros["estado"])->get();
                                }
                                if($filtros["fechaf"]!="" && $filtros["estado"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->where("detalleservicios.inicio", "<=", $filtros["fechaf"])
                                    ->where("detalleservicios.estado", $filtros["estado"])->get();
                                }
                                if($filtros["fechai"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->where("detalleservicios.inicio", ">=", $filtros["fechai"])->get();
                                }
                                if($filtros["fechaf"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->where("detalleservicios.inicio", "<=", $filtros["fechaf"])->get();
                                }
                                if($filtros["estado"]!=""){
                                    $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")
                                    ->where("detalleservicios.estado", $filtros["estado"])->get();
                                }
                                
                            }
                        }else{
                            $dato = DetalleServicio::with("detalletrabajos.detalletrabajocampos.campotrabajo.campoformularios")->with("detalletrabajos.colaboradortrabajos")->get();
                        }
                        
                    }
                     
                    break;
                case 'App\Sector':
                    $dato = Sector::all();

                    break;
                case 'App\Agencia':
                    $dato = Agencia::where("activo", "true")->get();

                    break;
                case 'App\Area':
                    $dato = Area::all();

                    break;
                case 'App\Colaboradore':
                    $dato = Colaboradore::where("estadocolab", "true")->get();

                    break;
                default:
                    # code...
                    break;
            }
            return $dato;
        }
    }
    public function setdatos(Request $request)
    {
        if($request->ajax()){
            
            switch ($request->tipo) {
                case 'nuevoservicio':
                    //return auth()->id();
                    $servicio = $request->newservicio;
                    $detalletrabajos = $request->detalletrabajo;
                    $serv = new DetalleServicio();
                    $serv->servicio_id = $servicio["servicio_id"];
                    $serv->fechaactivacion = $servicio["fechaactivacion"];
                    $serv->foliointerno = $servicio["foliointerno"];
                    $serv->folioexterno= $servicio["folioexterno"];
                    $serv->agencia_id = $servicio["agencia_id"];
                    $serv->responsable_id = auth()->id();
                    $serv->user_id = auth()->id();
                    $serv->area_id = $servicio["area_id"];
                    $serv->ubicacion_id = $servicio["ubicacion_id"];
                    $serv->digitoidentificador = $servicio["digitoidentificador"];
                    $serv->contenido_id = $servicio["contenido_id"];
                    $serv->valorinicial=0;
                    $serv->valoragregado=0;
                    $serv->obsvaloragregado="";
                    $serv->valorfinal=0;
                    $serv->observacionservicio = $servicio["observacionservicio"];
                    $serv->asistentes = count($servicio["colaboradoresservicio"]);
                    $serv->inicio = $servicio["inicio"];
                    $serv->termino = date("Y-m-d H:i:s");
                    $serv->estado ='FINALIZADO';
                    $serv->save();
                    $valorservicio=0;
                    //return $serv->id;
                    time_nanosleep(0, 200000000);
                    foreach($detalletrabajos as $det){
                        $dettrab = new DetalleTrabajo();
                        $dettrab->detalleservicio_id = $serv->id;
                        $dettrab->serviciotrabajo_id = $det["id"];
                        $dettrab->fotoinicio = $det["trabajo"]["detalletrabajo"]["fotoinicio"];
                        $dettrab->fototermino = $det["trabajo"]["detalletrabajo"]["fototermino"];
                        $dettrab->asistentes = count($det["trabajo"]["detalletrabajo"]["colaboradores"]);
                        $dettrab->valoragregado =0;
                        $dettrab->termino = date("Y-m-d H:i:s");
                        $dettrab->obsvaloragregado ="";
                        $dettrab->observaciontabulada_id = $det["trabajo"]["detalletrabajo"]["observaciontabulada_id"];
                        $tarifario = Tarifario::where("serviciotrabajo_id", $det["id"])->first();
                        $valorservicio = $valorservicio+$tarifario->valor;
                        $dettrab->valorinicial = $tarifario->valor;
                        $dettrab->valorfinal = $tarifario->valor;
                        $dettrab->user_id = auth()->id();
                        $dettrab->save();
                        time_nanosleep(0, 200000000);
                        if(count($det["trabajo"]["detalletrabajo"]["colaboradores"])>0){
                            foreach ($det["trabajo"]["detalletrabajo"]["colaboradores"] as $colabdet) {
                                $colab = new ColaboradorTrabajo();
                                $colab->detalletrabajo_id = $dettrab->id;
                                $colab->colaborador_id = $colabdet["rutcolaborador"];
                                $colab->turno =1;
                                $colab->horario = date("Y-m-d H:i:s");
                                $colab->save();
                            }
                        }
                        foreach ($det["trabajo"]["campotrabajo"] as $campodet) {
                            $detcampo = new DetalleTrabajoCampo();
                            $detcampo->detalleservicio_id = $serv->id;
                            $detcampo->detalletrabajo_id = $dettrab->id;
                            $detcampo->campotrabajo_id = $campodet["id"];
                            if($campodet["campoformularios"]["tipo"]==''){
                                $detcampo->valor = date('Y-m-d H:i:d', strtotime($campodet["campoformularios"]["value"]));
                            }else{
                                $detcampo->valor = $campodet["campoformularios"]["value"];
                            }
                            
                            $detcampo->user_id = auth()->id();
                            $detcampo->save();
                        }
                    }
                    $serv->valorinicial=$valorservicio;
                    $serv->valorfinal=$valorservicio;
                    $serv->save();
                    return "";
                    break;
                case 'editarcolaborador':
                    
                    break;
                case 'crearusuario':
                    
                    break;
                case 'editarusuario':
                    
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            return view('servicios.index');
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
