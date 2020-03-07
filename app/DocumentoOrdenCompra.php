<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentoOrdenCompra extends Model
{
    use SoftDeletes;
    
    protected $table = 'documentosordencompras';

    public function ordencompras(){
        return $this->belongsTo("App\OrdenCompra",'nrooc', 'nrooc');
    }

    public function user(){
        return $this->belongsTo("App\User",'user_id', 'id');
    }
    
    public function proveedores(){
        return $this->belongsTo("App\Proovedore",'proveedor_id', 'rutproveedor');
    }

    public function recepcionoc(){
        return $this->hasMany("App\RecepcionOc",'doc_id', 'id');
    }
}
