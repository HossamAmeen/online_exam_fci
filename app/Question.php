<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  protected $fillable = ['QUESTION_TEXT' ,'QUESTION_TYPE_ID', 'POINTS' ,'hard','course_id', 'EXAM_ID'];
    public function exam()
    {
        return $this->belongsTo('App\Exam','EXAM_ID');
    }
    public function choices()
    {
        return $this->hasMany('App\Question_choice','QUESTION_ID');
    }
    public function ilos()
    {
        return $this->hasMany('App\Question_ilos','QUESTION_ID');
    }
    public function image()
    {
        return $this->hasOne(QuestionImage::class , 'question_id');
    }
    public function questiontype()
    {
        return $this->belongsTo('App\Question_type','QUESTION_TYPE_ID');
    }
}
