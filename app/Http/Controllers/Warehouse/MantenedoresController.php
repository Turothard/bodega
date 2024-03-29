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
class MantenedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('warehouse/mantenedores/mantenedor');
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
            switch ($request->tipo) {
                case 'articulos':
                    $arreglo[0] = Articulo::where('codigoart','<>',"''")
                    ->join('categorias', 'categorias.idcategoria','=', 'articulos.categoria_id')
                    ->join('subcategorias', 'subcategorias.idsubcategoria','=', 'articulos.subcategoria_id')
                    ->join('unidades', 'unidades.idunidad','=', 'articulos.unidad_id')
                    ->join('colores', 'colores.idcolor','=', 'articulos.color_id')
                    ->join('periodosdevos', 'periodosdevos.idperiodo','=', 'articulos.periododevo_id')
                    ->join('marcas', 'marcas.idmarca','=','articulos.marca_id')
                    ->select('articulos.codigoart','articulos.codigoalternativoart','articulos.categoria_id','categorias.codigocat','categorias.nombrecat',
                    'articulos.subcategoria_id','subcategorias.codigosubcat','subcategorias.nombresubcat','articulos.nombreart','articulos.proveedorart',
                    'articulos.descripcionart','articulos.color_id','colores.nombrecol','articulos.unidad_id','unidades.nombretipounimed','unidades.codigounimed',
                    'unidades.descripcionunimed','articulos.marca_id','marcas.nombremar','articulos.stockcriticoart','articulos.indicerotacionart',
                    'articulos.yearart','articulos.periododevo_id','periodosdevos.periododevo', 'periodosdevos.descripcionper','articulos.image')->get();
                    $arreglo[1] = Correlativo::selectRaw("subcategoria_id,max(correlativo) as correlativo")->groupBy("subcategoria_id")->orderBy("subcategoria_id")->get();
                    return $arreglo;
                    break;
                case 'categorias':
                    
                    break;
                case 'colores':
                    return  Colore::max("idcolor");
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            return view('mantenedores.index');
        }
    }
    public function setdatos(Request $request)
    {
        if($request->ajax()){
            switch ($request->tipo) {
                case 'nuevamarca':
                    $marcvue=$request->detalle;
                    $marca = new Marca();
                    $marca->idmarca = $marcvue["idmarca"];
                    $marca->nombremar = $marcvue["nombremar"];
                    $marca->save();
                    break;
                case 'nuevoarticulo':
                    $artvue=$request->detalle;
                    $art = new Articulo();         
                    $art->codigoart = $artvue["codigoart"];
                    $art->categoria_id = $artvue["categoria_id"];
                    $art->subcategoria_id = $artvue["subcategoria_id"];
                    
                    $art->proveedorart = $artvue["proveedorart"];
                    $art->descripcionart = Str::upper($artvue["descripcionart"]);
                    $art->color_id = $artvue["color_id"];
                    $col = Colore::find($artvue["color_id"]);
                    $uni = Unidade::find($artvue["unidad_id"]);
                    $art->unidad_id = $artvue["unidad_id"];
                    $art->marca_id = $artvue["marca_id"];
                    $art->nombreart = Str::upper($artvue["nombreart"]." ".$col->nombrecol." ".$uni->codigounimed);
                    $art->stockcriticoart = $artvue["stockcriticoart"];
                    $art->indicerotacionart = $artvue["indicerotacionart"];
                    $art->yearart = $artvue["yearart"];
                    $art->periododevo_id = $artvue["periododevo_id"];
                    $art->save();

                    $subcat = SubCategoria::find($artvue["subcategoria_id"]);
                    $correlativo =Correlativo::where("subcategoria_id",$artvue["subcategoria_id"])->max("correlativo");
                    $cor = new Correlativo();
                    $correlativo = "".((int)$correlativo+1);
                    $corre= $correlativo;
                    while(strlen($correlativo)<5){
                        $correlativo ="0".$correlativo;
                    }
                    $cor = new Correlativo();
                    $cor->subcategoria_id = $artvue["subcategoria_id"];
                    $cor->subcategoria = $subcat->codigosubcat;
                    $cor->correlativo = $corre;
                    $cor->correlativofinal = $subcat->codigosubcat.$correlativo;
                    $cor->save();
                    
                break;
                case 'editararticulo':
                    $artvue=$request->detalle;
                    $art = Articulo::find($artvue["codigoart"]);         
                    $art->descripcionart = Str::upper($artvue["descripcionart"]);
                    $col = Colore::find($art->color_id);
                    $uni = Unidade::find($art->unidad_id);
                    $art->nombreart = Str::upper($artvue["nombreart"]." ".$col->nombrecol." ".$uni->codigounimed);
                    $art->stockcriticoart = $artvue["stockcriticoart"];
                    $art->indicerotacionart = $artvue["indicerotacionart"];
                    $art->yearart = $artvue["yearart"];
                    $art->periododevo_id = $artvue["periododevo_id"];
                    $art->save();
                break;
                case 'nuevoproveedor':
                    $provvue= $request->prov;
                    $prov = Proveedore::find($provvue['rutproveedor']);
                    if($prov==null){
                        $codigo = Proveedore::max("codigoprov");
                        $prov= new Proveedore();
                        $prov->rutproveedor = $provvue['rutproveedor'];
                        $prov->nombreprov = $provvue['nombreprov'];
                        $prov->codigoprov = ((int)$codigo)+1;
                        $prov->giroprov = $provvue['giroprov'];
                        $prov->comunaprov = $provvue['comunaprov'];
                        $prov->direccionprov = $provvue['direccionprov'];
                        $prov->telefonoprov = $provvue['telefonoprov'];
                        $prov->correoprov = $provvue['correoprov'];
                        $prov->save();
                        return;
                    }else{
                        return '1';
                    }
                break;
                case 'nuevocolor':
                    $colvue =$request->detalle;
                    $col = new Colore();
                    $col->idcolor = $colvue["idcolor"];
                    $col->nombrecol = $colvue["nombrecol"];
                    $col->hexcol = $colvue["hexcol"];
                    $col->save();
                    break;
                case 'editarcolor':
                    $colvue =$request->detalle;
                    $col = Colore::find($colvue["idcolor"]);
                    $col->nombrecol = $colvue["nombrecol"];
                    $col->hexcol = $colvue["hexcol"];
                    $col->save();
                    break;
                case 'eliminarcolor':
                    $colvue =$request->detalle;
                    $col = Colore::find($colvue["idcolor"]);
                    $colart= Articulo::where("color_id",$colvue["idcolor"])->count();
                    if($colart==0){
                        $col->forceDelete();
                        return 0;
                    }else{
                        return 1;
                    }
                    
                    break;
                case 'nuevacategoria':
                    $catvue =$request->detalle;
                    $cat = Categoria::where("codigocat",$catvue["codigocat"])->get()->first();
                    if($cat!=null){
                        return 1;
                    }else{
                        $cat = Categoria::where("nombrecat",$catvue["nombrecat"])->get()->first();
                        if($cat!=null){
                            return 2;
                        }else{
                            $cat = new Categoria();
                            $cat->codigocat = $catvue["codigocat"];
                            $cat->nombrecat = $catvue["nombrecat"];
                            $cat->descripcioncat = $catvue["descripcioncat"];
                            $cat->save();
                            return 0;
                        }
                    }
                break;
                case 'editarcategoria':
                    $catvue =$request->detalle;
                    $cat = Categoria::where("codigocat",$catvue["codigocat"])->get()->first();
                    
                        $catw = Categoria::where("nombrecat",$catvue["nombrecat"])->get()->first();
                        if($catw!=null){
                            return 1;
                        }else{
                            //$cat->codigocat = $catvue["codigocat"];
                            $cat->nombrecat = $catvue["nombrecat"];
                            $cat->descripcioncat = $catvue["descripcioncat"];
                            $cat->save();
                            return 0;
                        }
                break;
                case 'eliminarcategoria':
                    $catvue =$request->detalle;
                    $cat = Categoria::where("codigocat",$catvue["codigocat"])->get()->first();
                    $catart= Articulo::where("categoria_id",$cat->idcategoria)->count();
                    $subcatart= SubCategoria::where("categoria_id",$cat->idcategoria)->count();
                    if($catart==0 && $subcatart==0){
                        $cat->forceDelete();
                        return 0;
                    }else{
                        return 1;
                    }
                    
                    break;
                case 'editarproveedor':
                    $provvue= $request->prov;
                    $prov = Proveedore::find($provvue['rutproveedor']);
                        $prov->rutproveedor = $provvue['rutproveedor'];
                        $prov->nombreprov = $provvue['nombreprov'];
                        
                        $prov->giroprov = $provvue['giroprov'];
                        $prov->comunaprov = $provvue['comunaprov'];
                        $prov->direccionprov = $provvue['direccionprov'];
                        $prov->telefonoprov = $provvue['telefonoprov'];
                        $prov->correoprov = $provvue['correoprov'];
                        $prov->save();
                        return;
                    
                break;
                default:
                    # code...
                    break;
            }
        }else{
            return view('mantenedores.index');
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
