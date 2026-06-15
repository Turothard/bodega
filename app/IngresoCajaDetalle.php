<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngresoCajaDetalle extends Model
{
    use SoftDeletes;
    protected $table = 'ingresoscajadetalle';

    protected $casts = [
        'codigoart'  =>  'string',
    ];

    public function ingresocajas(){
        return $this->belongsTo("App\IngresoCaja",'ingresocaja_id', 'id');
    }

}
