<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sectore extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idsector';
    protected $table = 'sectores';

    public function areas(){
        return $this->belongsTo("App\Area",'sector_id', 'idsector');
    }

    public function pedidos(){
        return $this->hasMany("App\Pedido",'sector_id', 'idsector');
    }
}
