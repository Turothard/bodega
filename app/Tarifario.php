<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarifario extends Model
{
    protected $table = 'tarifarios';

    public function user()
    {
        return $this->belongsTo("App\User",'user_id', 'id');
    }

    public function serviciotrabajo()
    {
        return $this->belongsTo("App\User",'serviciotrabajo_id', 'id');
    }
}
