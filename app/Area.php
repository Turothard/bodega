<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Area extends Model
{
  use SoftDeletes;
    protected $primaryKey = 'idarea';
    protected $table = 'areas';

   public function sectores()
  {
      return $this->belongsTo('App\Sectore', 'sector_id','idsector');
  }
  public function ubicaciones(){
      return $this->hasMany("App\Ubicacione",'area_id', 'idarea');
  }
  public function pedidos(){
      return $this->hasMany("App\Pedido",'area_id', 'idarea');
  }
  
}
