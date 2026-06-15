<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DetalleOrdenCompra extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'iddetalleoc';
    protected $table = 'detalleordencompras';

    public function ordencompra(){
        return $this->belongsTo("App\OrdenCompra",'ordencompra_id', 'nrooc');
    }

    public function bodega(){
        return $this->belongsTo("App\Bodega",'bodega_id', 'idbodega');
    }
    public function sectores(){
        return $this->belongsTo("App\Sectore",'sector_id', 'idsector');
    }
    public function colores(){
        return $this->belongsTo("App\Colore",'color_id', 'idcolor');
    }
    public function articulo(){
        return $this->belongsTo("App\Articulo",'codigoart', 'codigoart');
    }
    public function marcas(){
        return $this->belongsTo("App\Marca",'marca_id', 'idmarca');
    }
    public function unidades(){
        return $this->belongsTo("App\Unidade",'unidad_id', 'idunidad');
    }
    public function recepcionoc(){
        return $this->hasMany("App\RecepcionOc",'detoc_id', 'iddetalleoc');
    }
}
