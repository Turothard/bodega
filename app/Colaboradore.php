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
}
