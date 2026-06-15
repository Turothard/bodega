<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    public function camposervicios(){
        return $this->hasMany("App\CampoServicio", 'servicio_id','id');
    }

    public function serviciotrabajos(){
        return $this->hasMany("App\ServicioTrabajo", 'servicio_id','id');
    }

    public function user(){
        return $this->belongsTo("App\User",'user_id', 'id');
    }

    public function sector(){
        return $this->belongsTo("App\Sectore",'sector_id', 'id');
    }
}
