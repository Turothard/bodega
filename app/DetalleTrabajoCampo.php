<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleTrabajoCampo extends Model
{
    protected $table = 'detalletrabajocampos';
    
    public function detalletrabajo()
    {
        return $this->belongsTo("App\DetalleTrabajo",'detalletrabajo_id', 'id');
    }

    public function campotrabajo()
    {
        return $this->belongsTo("App\CampoTrabajo",'campotrabajo_id', 'id');
    }
    public function detalleservicios()
    {
        return $this->belongsTo("App\DetalleServicio",'detalleservicio_id', 'id');
    }
    public function user(){
        return $this->belongsTo("App\User",'user_id', 'id');
    }
}