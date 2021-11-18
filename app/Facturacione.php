<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacione extends Model
{
    protected $table = 'facturaciones';

    public function detalletrabajos()
    {
        return $this->hasMany('App\DetalleFacturacione', 'facturacion_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo("App\User",'user_id', 'id');
    }
}
