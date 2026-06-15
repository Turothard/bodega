<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleInventario extends Model
{
    use SoftDeletes;
    protected $table = 'detalleinventarios';
    protected $casts = [
        'bodega_id'  =>  'string',
        'codigoart'  =>  'string',
    ];

    public function inventarios(){
        return $this->belongsTo("App\Inventario",'inventario_id', 'id');
    }
}
