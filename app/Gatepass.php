<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gatepass extends Model
{
    //

    public function inv()
    {
       return $this->hasOne('App\Invoice');
    }
}
