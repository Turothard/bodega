<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampoTrabajo extends Model
{  
    protected $table = 'campotrabajos';

    public function campoformularios(){
        return $this->belongsTo("App\CampoFormulario",'campo_id', 'id');
    }

    public function trabajo()
    {
        return $this->belongsTo('App\Trabajo', 'trabajo_id', 'id');
    }

    public function detalletrabajocampos()
    {
        return $this->hasMany('App\DetalleTrabajoCampo','campotrabajo_id', 'id');
    }

    public function serviciotraajos()
    {
        return $this->hasMany('App\ServicioTrabajo','campotrabajo_id', 'id');
    }
}
