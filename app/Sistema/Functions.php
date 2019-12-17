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
							$receptor = Colaboradore::find($modeltabla->recptor_id);
							$not->grupoobjetivo="SUPERVISORES";
							$not->userobjetivo_id = $modeltabla->user_id;
							$userobjetivo = $modeltabla->user_id;
							$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> ha sido entregado en su totalidad, <br />Entregado A:".$receptor->nombrecortocolab."<br /> Artículos:".$modeltabla->cantidadproped;
						}
						if($modeltabla->estadoped=='FINALIZADO'){		
							if($detalletipo=='ENTREGADO'){
								$receptor = Colaboradore::find($modeltabla->recptor_id);
								$not->grupoobjetivo="SUPERVISORES";
								$not->userobjetivo_id = $modeltabla->user_id;
								$userobjetivo = $modeltabla->user_id;
								$not->mensaje="Pedido <strong>".$modeltabla->id."</strong> ha sido entregado y Finalizado, <br />Entregado A:".$receptor->nombrecortocolab."<br /> Artículos:".$modeltabla->cantidadproped;
							}else{
								$receptor = Colaboradore::find($modeltabla->recptor_id);
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
			
			default:
				# code...
				break;
		}
		$not->estado = 'INGRESADO';
		$not->save();
		time_nanosleep(0, 200000000);		
		
		if($userobjetivo!=''){
			$notiuser = new NotificacionesUser();
			$notiuser->notificacion_id = $not->id;
			$notiuser->user_id = $userobjetivo;
			$notiuser->estado = 'INGRESADO';
			$notiuser->save();
		}else{
			$users = User::where("department",$grupoobjetivo)->get();
			foreach ($users as $usuario) {
				$notiuser = new NotificacionesUser();
				$notiuser->notificacion_id = $not->id;
				$notiuser->user_id = $usuario->id;
				$notiuser->estado = 'INGRESADO';
				$notiuser->save();
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