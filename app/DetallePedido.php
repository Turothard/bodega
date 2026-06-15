<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetallePedido extends Model
{
    use SoftDeletes;
    protected $table = 'detallepedidos';
    protected $casts = [
        'estadodetped'  =>  'string',
        'observacionentregadetped'  =>  'string',
        'observaciondevoluciondetped'  =>  'string',
    ];
    public function pedidos(){
        return $this->belongsTo("App\Pedido",'pedido_id', 'id');
    }
    public function articulos(){
        return $this->belongsTo("App\Articulo",'codigoart', 'codigoart');
    }
    public function detallepedposiciones(){
        return $this->hasMany("App\DetallePedPosicione",'detallepedido_id', 'id');
    }
}
