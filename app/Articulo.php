<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articulo extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'codigoart';
    protected $table = 'articulos';
    protected $casts = [
        'nombreart'  =>  'string',
        'descripcionart'  =>  'string',
      ];
    public function categorias(){
        return $this->belongsTo("App\Categoria",'categoria_id', 'idcategoria');
    }

    public function subcategorias(){
        return $this->belongsTo("App\SubCategoria",'subcategoria_id', 'idsubcategoria');
    }

    public function colores(){
        return $this->belongsTo("App\Colore",'color_id', 'idcolor');
    }

    public function marcas(){
        return $this->belongsTo("App\Marca",'marca_id', 'idmarca');
    }

    public function unidades(){
        return $this->belongsTo("App\Unidade",'unidadart', 'idunidad');
    }
    public function detallepedidos(){
        return $this->hasMany("App\DetallePedido",'codigoart', 'codigoart');
    }
    public function detallepedposiciones(){
        return $this->hasMany("App\DetallePedPosicione",'codigoart', 'codigoart');
    }
    public function detalleordencompras(){
        return $this->hasMany("App\DetalleOrdenCompra",'codigoart', 'codigoart');
    }

    public function posiciones(){
        return $this->hasMany("App\Posicione",'codigoart', 'codigoart');
    }

    public function periododevos(){
        return $this->belongsTo("App\PerdiodoDevo",'periododevo_id', 'idperiodo');
    }
}
