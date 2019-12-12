<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacione extends Model
{
    use SoftDeletes;
    protected $table = 'notificaciones';
    protected $casts = [
        'tipo'  =>  'string',
        'tabla'  =>  'string',
        'destino'  =>  'string',
        'grupo'  =>  'string',
        'mensaje'  =>  'string',
        'estado'  =>  'string',
    ];
    public function usuario_proceso(){
        return $this->belongsTo("App\User",'usuario_proceso', 'id');
    }

    public function usuario_objetivo(){
        return $this->belongsTo("App\Colaboradore",'usuario_objetivo', 'rutcolaborador');
    }
    public function notificacionesuser(){
        return $this->hasMany("App\NotificacionesUser",'notificacion_id', 'id');
    }
}
