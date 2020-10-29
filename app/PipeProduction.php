<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PipeProduction extends Model
{
    //
    public function pipes()
    {
        return $this->belongsTo('App\Pipe','pipe_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
