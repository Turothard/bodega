<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colaboradore extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'rutcolaborador';
    protected $table = 'colaboradores';
    protected $casts = [
      'rutcolaborador'  =>  'string',
      'nombrescolab'  =>  'string',
      'apellidoscolab'  =>  'string',
      'deptocolab'  =>  'string'
    ];
    public function pedidosbodeguero()
    {
        return $this->hasMany('App\Pedido', 'bodeguero_id','rutcolaborador');
    }
    public function pedidosreceptor()
    {
        return $this->hasMany('App\Pedido', 'receptor_id','rutcolaborador');
    }
    public function detallepedposiciones()
    {
        return $this->hasMany('App\DetallePedPosicione', 'receptor_prod','rutcolaborador');
    }
}
