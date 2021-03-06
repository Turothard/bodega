<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class NotificacionesUser extends Model
{
    use SoftDeletes;
    protected $table = 'notificacionesuser';

    protected $casts = [
        'estado'  =>  'string',
    ];
    public function usuarios(){
        return $this->belongsTo("App\User",'user_id', 'id');
    }
    public function notificaciones(){
        return $this->belongsTo("App\Notificacione",'notificacion_id', 'id');
    }
}
