<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $table = 'trabajos';

    public function user(){
        return $this->belongsTo("App\User",'user_id', 'id');
    }

    public function sector(){
        return $this->belongsTo("App\Sectore",'sector_id', 'id');
    }

    public function campotrabajo(){
        return $this->hasMany("App\CampoTrabajo",'trabajo_id', 'id');
    }

    public function serviciotrabajos(){
        return $this->hasMany("App\ServicioTrabajo",'trabajo_id', 'id');
    }


}
