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
        'grupoobjetivo'  =>  'string',
        'estado'  =>  'string',
    ];
    public function userproceso(){
        return $this->belongsTo("App\User",'userproceso_id', 'id');
    }

    public function userobjetivo(){
        return $this->belongsTo("App\Colaboradore",'userobjetivo_id', 'rutcolaborador');
    }
    public function notificacionesuser(){
        return $this->hasMany("App\NotificacionesUser",'notificacion_id', 'id');
    }
}
