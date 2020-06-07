<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionExam extends Model
{
    public function questionsExams(){
        return $this->belongsToMany('App\Question','question_exams','exam_id','question_id');

    }
}
