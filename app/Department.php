<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public  function faculity()
    {
        return $this->belongsTo('App\Faculty','FACULTY_ID','id');
    }
}
