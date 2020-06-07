<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ilos extends Model
{
    public function course(){
        return $this->belongsTo('App\Course','COURSE_ID');
    }
    public function ilosType(){
        return $this->belongsTo('App\Ilo_type','ILO_TYPE_ID');
    }

}
