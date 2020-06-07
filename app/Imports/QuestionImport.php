<?php

namespace App\Imports;

use App\Question;
use App\Question_choice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] == "MCQ")
        {
            $type = 1;
        }
        elseif($row[0] == "TF")
        {
            $type = 2;
        }
        elseif($row[0] == "Essay")
        {
            $type = 3;
        }
        elseif($row[0] == "Code")
        {
            $type = 4;
        }
       elseif($row[0] == "Definition")
        {
          $type = 5 ;
        }
        $examId = null ;
        if(session('exam_id') !== null )
        $examId = session('exam_id') ;

       $question =  Question::create([
            'QUESTION_TYPE_ID'=> $type,
            'course_id'=>session('course_id'),
            'EXAM_ID' => $examId ,
            'hard' => $row[1],
            'QUESTION_TEXT' => $row[2],
            'POINTS' =>$row[7]
        ]);


        if($row[0] == "MCQ")
        {
            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $row[3];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $row[8] == 1 ? 1 : 0;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $row[4];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $row[8] == 2 ? 1 : 0;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $row[5];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $row[8] == 3 ? 1 : 0;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $row[6];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $row[8] == 4 ? 1 : 0;
            $question_choice->save();
        }
        elseif($row[0] == "TF")
        {
            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $row[3];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $row[8] == 1 ? 1 : 0;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $row[4];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $row[8] == 2 ? 1 : 0;
            $question_choice->save();
        }
        elseif($row[0] == "Essay")
        {
            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $row[3];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $row[8] == 1 ? 1 : 0;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $row[4];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $row[8] == 2 ? 1 : 0;
            $question_choice->save();
        }
        elseif($row[0] == "Code")
        {
            $type = 4;
        }
        else
        {

        }


        return ;

    }
    public function startRow(): int
    {
        return 2;
    }

}
