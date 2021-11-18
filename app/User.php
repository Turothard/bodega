<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','rut'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'rut'=>'string'
    ];

    public function notificaciones_proceso(){
        return $this->hasMany("App\Notificacione",'userproceso_id', 'id');
    }
    public function notificaciones_objetivo(){
        return $this->hasMany("App\Notificacione",'userobjetivo_id', 'id');
    }
    public function notificacionesuser(){
        return $this->hasMany("App\NotificacioneUser",'user_id', 'id');
    }
    public function ordenescompra(){
        return $this->hasMany("App\OrdenCompra",'user_id', 'id');
    }
    public function detalleservicio(){
        return $this->hasMany("App\DetallesServicio",'user_id', 'id');
    }
    public function servicio(){
        return $this->hasMany("App\Servicio",'user_id', 'id');
    }
    public function trabajo(){
        return $this->hasMany("App\Trabajo",'user_id', 'id');
    }

}
