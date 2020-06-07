<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function course(){
        return $this->belongsTo('App\Course','COURSE_ID');
    }
    public function semester(){
        return $this->belongsTo('App\Semester','SEMESTER_ID');
    }
    public function staff(){
        return $this->belongsTo('App\Staff','STAFF_ID');
    }
    public function questions(){
        return $this->hasMany('App\Question','EXAM_ID');

    }
    public function questionsExams(){
        return $this->belongsToMany('App\Question','question_exams','exam_id','question_id');

    }
    public function studentExams(){
        return $this->hasMany('App\StudentExam','exam_id','id');

    }

}
