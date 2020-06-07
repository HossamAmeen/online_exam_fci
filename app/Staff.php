<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function courses()
    {
        return $this->belongsToMany('App\Course', 'staff_courses', 'STAFF_ID', 'COURSE_ID');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'DEPARTMENT_ID');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
