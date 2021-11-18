<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleFacturacione extends Model
{
    protected $table = 'detallefacturaciones';

    public function facturacion()
    {
        return $this->belongsTo('App\Facturacione', 'facturacion_id', 'id');
    }

    public function tipofacturacion()
    {
        return $this->belongsTo('App\TipoFacturacione', 'facturacion_id', 'id');
    }

    public function sector()
    {
        return $this->belongsTo('App\Sectore', 'sector_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo("App\User",'user_id', 'id');
    }
}
