<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngresoOrdenCompra extends Model
{
    use SoftDeletes;
    
    protected $table = 'ingresoordencompras';

    public function ordencompras(){
        return $this->belongsTo("App\OrdenCompra",'nrooc', 'nrooc');
    }

    public function documento(){
        return $this->belongsTo("App\DocumentoOrdenCompra",'doc_id', 'id');
    }

    public function detalleordencompra(){
        return $this->belongsTo("App\DetalleOrdenCompra",'detoc_id', 'iddetalleoc');
    }
    public function recepcionoc(){
        return $this->belongsTo("App\RecepcionOc",'detoc_id', 'id');
    }
}
