<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColaboradorTrabajo extends Model
{
    protected $table = 'colaboradortrabajo';

    public function colaborador()
    {
        return $this->belongsTo('App\Colaboradore', 'colaborador_id', 'id');
    }
    public function detalletrabajo()
    {
        return $this->belongsTo('App\DetalleTrabajo', 'detalletrabajo_id', 'id');
    }
}
