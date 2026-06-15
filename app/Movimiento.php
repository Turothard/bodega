<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Movimiento extends Model
{
    use SoftDeletes;
    protected $table = 'movimientos';

   
}
