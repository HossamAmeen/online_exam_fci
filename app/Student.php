<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['STUDENT_NAME' ,'STUDENT_SSN','STUDENT_PASSWORD','FACULTY_ID' ,'DEPARTMENT_ID','term','semester','phone','user_id'];
    public function department()
    {
        return $this->belongsTo('App\Department', 'DEPARTMENT_ID');
    }
    public function faculty()
    {
        return $this->belongsTo('App\Faculty', 'FACULTY_ID');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
