<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question_ilos extends Model
{
    public function ilos()
    {
        return $this->belongsTo('App\Ilos','ILO_ID');

    }
}
