<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Ubicacione extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idubicacion';
    protected $table = 'ubicaciones';

    public function areas()
    {
        return $this->belongsTo('App\Area', 'area_id','idarea');
    }

    public function pedidos()
    {
        return $this->hasMany('App\Pedido', 'ubicacion_id', 'idubicacion');
    }
    
    public function detalleservicios()
    {
        return $this->hasMany('App\DetalleServicio', 'ubicacion_id', 'id');
    }
}
