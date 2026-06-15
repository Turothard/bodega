<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampoServicio extends Model
{
    protected $table = 'camposervicios';

    public function servicios()
    {
        return $this->belongsTo('App\Servicio', 'servicio_id','id');
    }
}
