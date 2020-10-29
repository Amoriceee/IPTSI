<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $attributes = [
        'authorised' => 0,
        'loaded' => 0
    ];

    public function clients()
    {
        return $this->belongsTo('App\Clients','client_id');
    }

    public function pipeinv()
    {
        return $this->hasMany('App\PipeInvoice','invoice_id');
    }

}
