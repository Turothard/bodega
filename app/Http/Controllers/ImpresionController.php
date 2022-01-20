<?php

namespace App\Http\Controllers;
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
use App\DetallePedPosicione;
use App\Pedido;
use App\DetalleInventario;
use App\Posicione;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImpresionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function imprimir($id){
        $pedido=Pedido::where("pedidos.id",$id)
        ->join('users', 'users.id','=','pedidos.user_id')
        ->join('colaboradores', 'colaboradores.rutcolaborador', '=', 'users.rut')
        ->select('pedidos.*', 'colaboradores.rutcolaborador', 'colaboradores.nombrecortocolab','colaboradores.cargocolab', 
        'colaboradores.sectorcolab')->get()->first();
        $bodeguero = Colaboradore::where("rutcolaborador",$pedido->bodeguero_id)->get()->first();
        $detalle = DetallePedido::where("pedido_id",$id)
        ->join('detallepedposiciones','detallepedidos.id','=','detallepedposiciones.detallepedido_id')
        ->join('posiciones','detallepedposiciones.posicion_id','=','posiciones.idposicion')
        ->join('estantes','estantes.id','=','posiciones.estante_id')
        ->join('articulos', 'articulos.codigoart','=', 'detallepedposiciones.codigoart')
        ->join('colaboradores', 'colaboradores.rutcolaborador', 'detallepedposiciones.receptor_prod')
        ->select('estantes.bodega_id','detallepedidos.tipodetped','detallepedidos.pedido_id','identusodetped','obsentped','obsdevodetped','estadodetped',
        'detallepedposiciones.id','detallepedposiciones.detallepedido_id','detallepedposiciones.codigoart','detallepedposiciones.posicion_id',
        'detallepedposiciones.cantidadpedido','detallepedposiciones.cantidadproceso','detallepedposiciones.cantidaddevolucion','articulos.nombreart',
        'detallepedposiciones.receptor_prod','posiciones.sectorpos', 'posiciones.nivelpos','estantes.nroestante', 'colaboradores.nombrecortocolab', 
        'colaboradores.cargocolab')->orderBy("detallepedposiciones.receptor_prod","ASC")
        ->get();
        //dd($id);
        //$id=1;
        $pdf = \PDF::loadView('warehouse/documentos/entregapdf2', compact('pedido','detalle', 'bodeguero'));
        return $pdf->download('Entrega pedido '.$pedido->id.'.pdf');
   }

   public function cajachica($fechai,$fechaf){
       $compras = IngresoCaja::where("fechaingresoing", ">=", $fechai)
       ->where("fechaingresoing", "<=", $fechaf)
       ->join('ingresoscajadetalle', 'ingresoscajadetalle.ingresocaja_id', '=','ingresoscaja.id')
       ->join('articulos', 'articulos.codigoart', '=', 'ingresoscajadetalle.codigoart')
       ->select('ingresoscaja.proveedor_id', 'ingresoscaja.nombreproving', 'ingresoscaja.tipodocing', 'ingresoscaja.nrodocing',
       'ingresoscajadetalle.codigoart', 'articulos.nombreart', 'ingresoscajadetalle.cantidading','ingresoscajadetalle.precioing',
       'ingresoscajadetalle.totaling', 'ingresoscaja.fechaingresoing')->orderBy("ingresoscaja.proveedor_id", "ASC")
       ->orderBy('ingresoscaja.fechaingresoing', "ASC")->get();
       $pdf = \PDF::loadView('warehouse/documentos/cajachica', compact('fechai','fechaf', 'compras'))->setPaper('a4', 'landscape');;
        return $pdf->download('Informe Caja Chica '.date('dmY').'.pdf');
   }
}
