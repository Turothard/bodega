<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Categoria extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idcategoria';
    protected $table = 'categorias';

    public function subcategorias(){
        return $this->hasMany("App\SubCategoria",'categoria_id', 'idcategoria');
    }

    public function articulos(){
        return $this->hasMany("App\Articulo",'categoria_id', 'idcategoria');
    }
    public function ordencompras(){
        return $this->hasMany("App\OrdenCompra",'categoria_id', 'idcategoria');
    }
}
