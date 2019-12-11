<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PeriodoDevo extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idperiodo';
    protected $table = 'periododevos';
    //
    public function articulos()
    {
        return $this->hasmany('App\Articulo', 'periododevo_id', 'idperiodo');
    }
}
