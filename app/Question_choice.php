<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question_choice extends Model
{
    public function image()
    {
        return $this->hasOne(ChooseImage::class , 'question_choice_id');
    }
}
