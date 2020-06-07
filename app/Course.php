<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function department(){
        return $this->belongsTo('App\Department','DEPARTMENT_ID');
    }
    public function doctor()
    {
        return $this->belongsToMany('App\Staff');
    }
	  public function exams(){
        return $this->hasMany('App\Exam','COURSE_ID');
    }

}
