<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFacturacione extends Model
{
    protected $table = 'tipofacturaciones';

    public function detallefacturaciones()
    {
        return $this->hasMany('App\DetalleFacturacione', 'tipofacturacion_id', 'id');
    }
    
    public function serviciotrabajos()
    {
        return $this->hasMany('App\ServicioTrabajo', 'tipofacturacion_id', 'id');
    }
}
