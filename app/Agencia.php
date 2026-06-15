<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
    protected $table = 'agencias';
    public function Detalleservicios()
    {
        return $this->hasMany('App\DetalleServicio','servicio_id', 'id');
    }
}
