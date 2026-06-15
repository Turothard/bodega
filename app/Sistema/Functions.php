<?php
use App\Notificacione;
use App\NotificacionesUser;
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
use App\Inventario;
use App\DetalleInventario;

if ( !function_exists('guardarnotificacion') )
{
	function guardarnotificacion($user, $tipo,$detalletipo, $tabla,$modeltabla,$dataaxuliar){
		$not = new Notificacione();
		$usuario = User::find($user);
		//return $usuario;
		$grupoobjetivo='';
		$userobjetivo='';
		$not->tipo = $tipo;
		$not->tabla = $tabla;
		$not->userproceso_id = $user;
		switch ($tabla) {
			case 'pedidos':
				$usuariopedido = User::find($modeltabla->user_id);
				$not->id_tabla = $modeltabla->id;
				$not->destino ='/pedidos';
				$sector = Sectore::find($modeltabla->sector_id);
				//return $usuario->department;
				$not->grupo=$usuario->department;
				switch ($tipo) {
					case 'INGRESO':
						
						if($modeltabla->estadoped=='PENDIENTE'){
							$not->grupoobjetivo="SUPERVISORES";
							$grupoobjetivo="SUPERVISORES";
							$not->mensaje="Nuevo Pedido <strong>".$modeltabla->id."</strong> Ingresado <br />Usuario:".$usuariopedido->name."<br /> Sector:".$sector->nombresec;
						}
						if($modeltabla->estadoped=='INGRESADO'){
							$not->grupoobjetivo="BODEGA";
							$not->destino ='/bodega';
							$grupoobjetivo="BODEGA";
							$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> Aceptado <br />Supervisor:".$usuario->name."<br /> Artículos:".$modeltabla->cantidadped;
						}
						break;
					case 'ACTUALIZACION':
						if($detalletipo=='CANCELADO'){							
							$receptor = Colaboradore::find($modeltabla->receptor_id);
							$not->grupoobjetivo="SUPERVISORES";
							$not->userobjetivo_id = $modeltabla->user_id;
							$userobjetivo = $modeltabla->user_id;
							$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> ha sido cancelado. <br />Cancelado Por:".$usuario->name."<br />";
						}
						if($modeltabla->estadoped=='PROCESADO'){
							if($detalletipo=='PROCESADO'){
								$not->grupoobjetivo="SUPERVISORES";
								//$grupoobjetivo="SUPERVISORES";
								$not->userobjetivo_id = $modeltabla->user_id;
								$userobjetivo = $modeltabla->user_id;
								$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> ha sido procesado por bodega, favor retirar <br />Bodeguero:".$usuario->name."<br /> Artículos:".$sector->nombresec;
							}else{
								$not->grupoobjetivo="SUPERVISORES";
								//$grupoobjetivo="SUPERVISORES";
								$not->userobjetivo_id = $modeltabla->user_id;
								$userobjetivo = $modeltabla->user_id;
								$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> ha sido entregado de forma parcial, favor revisar <br />Bodeguero:".$usuario->name."";
							}
							
						}
						if($modeltabla->estadoped=='ENTREGADO'){							
							$receptor = Colaboradore::find($modeltabla->receptor_id);
							$not->grupoobjetivo="SUPERVISORES";
							$not->userobjetivo_id = $modeltabla->user_id;
							$userobjetivo = $modeltabla->user_id;
							$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> ha sido entregado en su totalidad, <br />Entregado A:".$receptor->nombrecortocolab."<br /> Artículos:".$modeltabla->cantidadproped;
						}
						if($modeltabla->estadoped=='FINALIZADO'){		
							if($detalletipo=='ENTREGADO'){
								$receptor = Colaboradore::find($modeltabla->receptor_id);
								$not->grupoobjetivo="SUPERVISORES";
								$not->userobjetivo_id = $modeltabla->user_id;
								$userobjetivo = $modeltabla->user_id;
								$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> ha sido entregado y Finalizado, <br />Entregado A:".$receptor->nombrecortocolab."<br /> Artículos:".$modeltabla->cantidadproped;
							}else{
								$receptor = Colaboradore::find($modeltabla->receptor_id);
								$not->grupoobjetivo="SUPERVISORES";
								$not->userobjetivo_id = $modeltabla->user_id;
								$userobjetivo = $modeltabla->user_id;
								$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> ha sido finalizado con éxito, <br />Entregado A:".$receptor->nombrecortocolab."<br /> Artículos:".$modeltabla->cantidadproped;
							}		
							
						}
						break;
					default:
						//return;
						break;
				}
				
				break;
			case 'inventarios':
				
				$inv = Inventario::find($modeltabla->id);
				$userinventario = User::where("rut",$inv->userinv)->first();
				$not->id_tabla = $modeltabla->id;
				$not->destino ='/bodega';
				$not->grupo=$usuario->department;
				switch ($tipo) {
					case 'INGRESO':
						
						$not->grupoobjetivo="ADMIN";
						$grupoobjetivo="ADMIN";
						$not->mensaje="Nuevo inventario <strong>".$modeltabla->id." - ".$inv->tipoinv."</strong> Creado <br />Usuario:".$userinventario->name."<br /> Bodega:".$inv->bodega_id;
						break;
					case 'ACTUALIZACION':
						$not->grupoobjetivo="ADMIN";
						$grupoobjetivo="ADMIN";
						$not->mensaje="Actualización inventario <strong>".$modeltabla->id."</strong><br />Total Bodega: ".$inv->cantidadbodtotal."<br />Total Inventario: ".$inv->cantidadinvtotal."<br />Total Diferencia: ".$inv->cantidaddiftotal."";
						break;
					case 'FINALIZADO':
						$not->grupoobjetivo="ADMIN";
						$grupoobjetivo="ADMIN";
						$not->mensaje="Inventario Finalizado<strong>".$modeltabla->id."</strong><br />Total Bodega: ".$inv->cantidadbodtotal."<br />Total Inventario: ".$inv->cantidadinvtotal."<br />Total Diferencia: ".$inv->cantidaddiftotal."";
						break;
					default:
						# code...
						break;
				}
			break;
			default:
				# code...
				break;
		}
		$not->estado = 'INGRESADO';
		$not->save();
		time_nanosleep(0, 200000000);		
		
		if($userobjetivo!=''){
			if($grupoobjetivo!='ADMIN'){
				$notiuser = new NotificacionesUser();
				$notiuser->notificacion_id = $not->id;
				$notiuser->user_id = $userobjetivo;
				$notiuser->estado = 'INGRESADO';
				$notiuser->save();
			}
		}else{
			if($grupoobjetivo!='ADMIN'){
				$users = User::where("department",$grupoobjetivo)->get();
				foreach ($users as $usuario) {
					$notiuser = new NotificacionesUser();
					$notiuser->notificacion_id = $not->id;
					$notiuser->user_id = $usuario->id;
					$notiuser->estado = 'INGRESADO';
					$notiuser->save();
				}
			}
			
		}
		$users = User::where("department",'ADMIN')->get();
			foreach ($users as $usuario) {
				$notiuser = new NotificacionesUser();
				$notiuser->notificacion_id = $not->id;
				$notiuser->user_id = $usuario->id;
				$notiuser->estado = 'INGRESADO';
				$notiuser->save();
			}
		return '1';
	}
}
?>