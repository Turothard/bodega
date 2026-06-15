<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenCompra extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'nrooc';
    protected $table = 'ordencompras';
    protected $casts = [
        'estadooc'  =>  'string',
    ];
    public function categorias(){
        return $this->belongsTo("App\Categoria",'categoria_id', 'idcategoria');
    }

    public function proveedores(){
        return $this->belongsTo("App\Proovedore",'proveedor_id', 'rutproveedor');
    }
    public function user(){
        return $this->belongsTo("App\User",'user_id', 'id');
    }

    public function detalleordencompras(){
        return $this->hasMany("App\DetalleOrdenCompra",'ordencompra_id', 'nrooc');
    }

    public function recepcionoc(){
        return $this->hasMany("App\RecepcionOc",'nrooc', 'nrooc');
    }

    public function documentosoc(){
        return $this->hasMany("App\DocumentoOrdenCompra",'nrooc', 'nrooc');
    }
}
