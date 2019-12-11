<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Bodega extends Model
{
  use SoftDeletes;
  protected $primaryKey = 'idbodega';
  protected $table = 'bodegas';
  protected $casts = [
    'idbodega'  =>  'string'
];
  public $timestamps=false;
  
  public function estantes()
    {
        return $this->hasMany('App\Estante', 'bodega_id', 'idbodega');
    }
}
