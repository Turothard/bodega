<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleTrabajo extends Model
{
    protected $table = 'detalletrabajos';

    public function detalletrabajocampo()
    {
        return $this->hasOne('App\DetalleTrabajoCampo', 'detalletrabajo_id', 'id');
    }
    public function colaboradortrabajos()
    {
        return $this->hasMany('App\ColaboradorTrabajo', 'detalletrabajo_id', 'id');
    }

    public function observaciontabulada()
    {
        return $this->belongsTo("App\ObservacionTabulada",'observaciontabulada_id', 'id');
    }

    public function serviciotrabajo()
    {
        return $this->belongsTo("App\ServicioTrabajo",'trabajo_id', 'id');
    }

    public function detalleservicio()
    {
        return $this->belongsTo("App\DetalleServicio",'trabajo_id', 'id');
    }
}
