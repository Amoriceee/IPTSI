<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledgers extends Model
{
    //
    public function clients()
    {
        return $this->belongsTo('App\Clients','client_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','recieved_by');
    }
}
