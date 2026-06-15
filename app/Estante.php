<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Estante extends Model
{
    use SoftDeletes;
    protected $table = 'estantes';
    //
    public function bodegas()
    {
        return $this->belongsTo('App\Bodega','bodega_id', 'idbodega');
    }
    public function posiciones()
    {
        return $this->hasMany('App\Posicione', 'estante_id', 'id');
    }
}
