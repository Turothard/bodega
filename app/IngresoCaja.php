<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngresoCaja extends Model
{
    use SoftDeletes;
    protected $table = 'ingresoscaja';
    protected $casts = [
        'proveedor_id'  =>  'string',
        'usering'  =>  'string',
        'nombreproving'  =>  'string',
        'tipodocing'  =>  'string',
        'nrodocing'  =>  'string',
    ];

    public function ingresocajadetalles(){
        return $this->hasMany("App\IngresoCajaDetalle",'ingresocaja_id', 'id');
    }
}
