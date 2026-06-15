<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioTrabajo extends Model
{
    protected $table = 'serviciotrabajos';

    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicio_id', 'id');
    }

    public function trabajo()
    {
        return $this->belongsTo('App\Trabajo', 'trabajo_id', 'id');
    }

    public function tipofacturacion()
    {
        return $this->belongsTo('App\TipoFacturacione', 'tipofacturacion_id', 'id');
    }

    public function campotrabajo()
    {
        return $this->belongsTo('App\CampoTrabajo', 'campotrabajo_id', 'id');
    }

    public function tarifario()
    {
        return $this->hasOne('App\Tarifario', 'serviciotrabajo_id', 'id');
    }
    
    public function detalletrabajos()
    {
        return $this->hasMany('App\DetalleTrabajo', 'serviciotrabajo_id', 'id');
    }
}
