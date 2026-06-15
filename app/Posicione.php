<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Posicione extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idposicion';
    protected $table = 'posiciones';
    protected $casts = [
        'cantidadpos'  =>  'integer',

    ];

    public function estantes(){
        return $this->belongsTo("App\Estante",'estante_id', 'id');
    }

    public function articulos(){
        return $this->belongsTo("App\Articulo",'codigoart', 'codigoart');
    }

    public function detallepedposiciones(){
        return $this->hasMany("App\DetallePedPosicione",'posicion_id', 'idposicion');
    }
}
