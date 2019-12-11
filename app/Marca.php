<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idmarca';
    protected $table = 'marcas';

    public function articulos()
    {
        return $this->hasmany('App\Articulos', 'marca_id', 'idmarca');
    }

    public function detalleordencompras()
    {
        return $this->hasmany('App\DetalleOrdenCompra', 'marca_id', 'idmarca');
    }
}

