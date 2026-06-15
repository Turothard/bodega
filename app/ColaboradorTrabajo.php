<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColaboradorTrabajo extends Model
{
    protected $table = 'colaboradortrabajos';

    public function colaborador()
    {
        return $this->belongsTo('App\Colaboradore', 'colaborador_id', 'rutcolaborador');
    }
    public function detalletrabajo()
    {
        return $this->belongsTo('App\DetalleTrabajo', 'detalletrabajo_id', 'id');
    }
}
