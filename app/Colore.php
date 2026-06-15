<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Colore extends Model
{
    use SoftDeletes;
      protected $primaryKey = 'idcolor';
      protected $table = 'colores';
      protected $casts = [
        'idcolor'  =>  'string'
    ];
      public $timestamps=false;
      public function articulo()
      {
          return $this->hasMany('App\Articulo', 'color_id', 'idcolor');
      }
      public function detalleordencompra()
      {
          return $this->hasMany('App\DetalleOrdenCompra', 'color_id', 'idcolor');
      }
}
