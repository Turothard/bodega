<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Proveedore extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'rutproveedor';
    protected $table = 'proveedores';
    protected $casts = [
        'rutproveedor'  =>  'string'
    ];
    public function ordencompras()
    {
        return $this->hasMany('App\OrdenCompra', 'proveedor_id', 'rutproveedor');
    }
}
