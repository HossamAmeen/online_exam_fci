<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }
//    public function course()
//    {
//        return $this->belongsTo('App\Course', 'cour');
//    }
    public function exam()
    {
        return $this->belongsTo('App\Exam', 'exam_id');
    }

}
