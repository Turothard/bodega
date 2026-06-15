<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleServicio extends Model
{
    protected $table = 'detalleservicios';
    
    public function area()
    {
        return $this->belongsTo('App\Area','servicio_id', 'id');
    }
    public function ubicacion()
    {
        return $this->belongsTo('App\Ubicacion','ubicacion_id', 'id');
    }
    public function contenido()
    {
        return $this->belongsTo('App\Contenido','contenido_id', 'id');
    }
    public function agencia()
    {
        return $this->belongsTo('App\Agencia','agencia_id', 'id');
    }
    public function servicio()
    {
        return $this->belongsTo('App\Servicio','servicios_id', 'id');
    }
    public function user(){
        return $this->belongsTo("App\User",'user_id', 'id');
    }
    public function detalletrabajos()
    {
        return $this->hasMany('App\DetalleTrabajo', 'detalleservicio_id', 'id');
    }
    public function detalletrabajocampos()
    {
        return $this->hasMany('App\DetalleTrabajoCampo', 'detalleservicio_id', 'id');
    }
}
