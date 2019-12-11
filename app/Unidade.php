<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Unidade extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idunidad';
  protected $table = 'unidades';
  protected $casts = [
    'idunidad'  =>  'string'
];

  public function articulos()
  {
      return $this->hasmany('App\Articulos', 'tallaart', 'idtalla');
  }

  public function detalleordencompras()
  {
      return $this->hasmany('App\DetalleOrdenCompra', 'talladetoc', 'idtalla');
  }
}
