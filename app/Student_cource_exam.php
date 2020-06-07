<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_cource_exam extends Model
{
    protected $fillable = ['STUDENT_ID' , 'COURSE_ID'];
    public function student()
    {
        return $this->belongsTo('App\Student', 'STUDENT_ID');
    }
    public function course()
    {
        return $this->belongsTo('App\Course', 'COURSE_ID');
    }
    public function exam()
    {
        return $this->belongsTo('App\Exam', 'EXAM_ID');
    }

}
