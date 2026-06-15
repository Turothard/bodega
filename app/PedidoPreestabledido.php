<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoPreestabledido extends Model
{
    use SoftDeletes;
    protected $table = 'pedidospreestablecidos';
    protected $casts = [
        'tipopedido'  =>  'string',
        'nombretipoped'  =>  'string',
    ];
    public function users(){
        return $this->hasOne("App\Pedido",'pedido_id', 'id');
    }
}
