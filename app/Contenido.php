<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $table = 'contenidos';
    public function Detalleservicios()
    {
        return $this->hasMany('App\DetalleServicio','servicio_id', 'id');
    }
}
