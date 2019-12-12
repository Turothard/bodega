<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Pedido extends Model
{
    use SoftDeletes;
    protected $table = 'pedidos';
    protected $casts = [
        'tipopedido'  =>  'string',
        'bodeguero_id'  =>  'string',
        'receptor_id'  =>  'string',
    ];
    public function users(){
        return $this->belongsTo("App\User",'user_id', 'id');
    }

    public function areas(){
        return $this->belongsTo("App\Area",'area_id', 'idarea');
    }

    public function sectores(){
        return $this->belongsTo("App\Sector",'sector_id', 'idsector');
    }

    public function ubicaciones(){
        return $this->belongsTo("App\Ubicacione",'ubicacion_id', 'idubicacion');
    }

    public function bodegueros(){
        return $this->belongsTo("App\Colaboradore",'bodeguero_id', 'rutcolaborador');
    }

    public function receptores(){
        return $this->belongsTo("App\Colaboradore",'receptor_id', 'rutcolaborador');
    }

    public function detallepedidos(){
        return $this->hasMany("App\DetallePedido",'pedido_id', 'id');
    }
}
