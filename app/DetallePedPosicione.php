<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DetallePedPosicione extends Model
{
    use SoftDeletes;
    protected $table = 'detallepedposiciones';

    public function detallepedidos(){
        return $this->belongsTo("App\DetallePedido",'detallepedido_id', 'id');
    }

    public function colaboradores(){
        return $this->belongsTo("App\Colaboradore",'receptor_prod', 'rutcolaborador');
    }

    public function posiciones(){
        return $this->belongsTo("App\Posicione",'posicion_id', 'idposicion');
    }
    public function articulos(){
        return $this->belongsTo("App\Articulo",'codigoart', 'codigoart');
    }
}
