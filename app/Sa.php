<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sa extends Model
{
    public function faculity()
    {
        return $this->belongsTo('App\Faculty', 'SA_FACULTY_ID');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
