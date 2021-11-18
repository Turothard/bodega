<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampoFormulario extends Model
{
    protected $table = 'campoformularios';

    public function campotrabajos()
    {
        return $this->hasMany('App\CampoTrabajo','campo_id', 'id');
    }
}
