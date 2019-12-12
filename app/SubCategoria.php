<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategoria extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idsubcategoria';
    protected $table = 'subcategorias';

    public function categorias(){
        return $this->belongsTo("App\Categoria",'categoria_id', 'idcategoria');
    }

    public function articulos(){
        return $this->hasMany("App\Articulo",'subcategoria_id', 'idsubcategoria');
    }
    
}
