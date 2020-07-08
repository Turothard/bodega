<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DocSustentatorio extends Model
{
    use SoftDeletes;
      protected $table = 'docsustentatorios';
      protected $casts = [
        'tipodocumento'  =>  'string',
        'nrodocumento'  =>  'string',
        'dctofisico'  =>  'string'
    ];
      //public $timestamps=false;
      
      
}
