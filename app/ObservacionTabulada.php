<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObservacionTabulada extends Model
{
    protected $table = 'observaciontabuladas';

    public function detalletrabajos()
    {
        return $this->hasMany('App\DetalleTrabajos', 'observaciontabulada_id', 'id');
    }
}
