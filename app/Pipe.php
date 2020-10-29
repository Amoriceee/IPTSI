<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pipe extends Model
{
    //

    public function invoices()
    {
        return $this->belongsTo('App\PipeInvoice','id');
    }

    public function production()
    {
        return $this->belongsTo('App\PipeProduction','id');
    }
}
