<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use SoftDeletes;
    protected $table = 'inventarios';
    protected $casts = [
        'tipoinv'  =>  'string',
        'bodega_id'  =>  'string',
        'userinv'  =>  'string',
        'observacioninv'  =>  'string',
    ];

    public function detalleinventarios(){
        return $this->hasMany("App\DetalleInventario",'inventario_id', 'id');
    }
}
