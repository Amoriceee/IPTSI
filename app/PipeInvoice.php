<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PipeInvoice extends Model
{
    //
    protected $attributes = [
        'loaded' => 0
    ];

    public function pipes()
    {
        return $this->belongsTo('App\Pipe','pipe_id');
    }

    public function invoices()
    {
        return $this->belongsTo('App\Invoice','invoice_id');
    }
}
