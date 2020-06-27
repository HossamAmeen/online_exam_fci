<?php

namespace App\Http\Controllers\admin;

use App\Exam;
use App\ExamStudentModule;
use App\Http\Controllers\Controller;
use App\Question;
use App\QuestionExam;
use App\Question_choice;
use App\StudentExam;
use App\StudentExamImage;
use App\Student_cource_exam;
use App\Stud_ques_ans_choice;
use App\Time;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class StudentExamsController extends Controller
{
    public function index()
    {
        // return "test";
        date_default_timezone_set('Africa/Cairo');
        $today_date = date('m/d/Y');
        // return auth()->user()->student->id ;
        $exams = StudentExam::where('student_id', auth()->user()->student->id)->get()->pluck('exam_id');
        
        $courses = Student_cource_exam::where('STUDENT_ID', auth()->user()->student->id)
            ->get()->pluck('COURSE_ID');

        $exams = Exam::whereNotIn('id', $exams)->whereIn('COURSE_ID', $courses)->get();
        //dd($exams);
        $studentExams = StudentExam::where('student_id', auth()->user()->student->id)
        ->where('result', '!=', 'null')
        ->get();
        //dd($studentExams,$exams);
        // return $exams;
        return view('student.exams', compact('exams', 'studentExams', 'today_date'));

    }
    public function getCurrentTimeInMilliseconds()
    {
        $string = "00:38:42,689";
        $string = date('H:i:s,u');
        $time   = explode(":", $string);

        $hour   = $time[0] * 60 * 60 * 1000;
        $minute = $time[1] * 60 * 1000;

        $second = explode(",", $time[2]);
        $sec    = $second[0] * 1000;
        $milisec= $second[1];

        $result = $hour + $minute + $sec + $milisec;

        return $result;
    }
    public function startExam(Exam $exam)
    {

        $stude = StudentExam::where('exam_id', $exam->id)->where('student_id', auth()->user()->student->id)->first();
        if (!$stude) {
            date_default_timezone_set('Africa/Cairo');
            $time = Time::where('user_id', auth()->user()->id)->where('exam_id', $exam->id)->first();
            // dd($time);
            // return $time;
            $start_time = date('G:i');
            if (!$time) {
                // return "test time";
                $start_time = date('G:i');
                $endTime = date("Y-m-d G:i", strtotime('+' . $exam->EXAM_DURATION . ' minutes', strtotime($start_time)));
                // $endTime = date("Y-m-d G:i",strtotime($endTime) );
                // $endTime2 = date("Y-m-d G:i", strtotime('+' . $exam->EXAM_DURATION . ' minutes', strtotime($start_time)));
                $time = new Time();
                $time->user_id = auth()->user()->id;
                $time->exam_id = $exam->id;
                $time->time = $start_time;
                $time->enddate = $endTime;

                $time->save();
                Log::info("start time : " .date("G:i") . " end time " . $endTime );
                Log::info("student : " . auth()->user()->student->STUDENT_NAME . ' id : ' . auth()->user()->student->id );
            } else {
                $endTime = $time->enddate;

            }
            // dd(date("G:i"), $endTime);
            // if(date("G:i") <= $endTime){
                
            if (strtotime(date("G:i")) <= strtotime($endTime)) {
                session()->put('endTime', $endTime);
                $student_questions = ExamStudentModule::where('student_id', auth()->user()->student->id)
                    ->where('exam_id', $exam->id)->first();
                // return $student_questions;
                // return auth()->user()->student->id ;
                $sum_array = array(0, 0, 0, 0, 0, 0);
                if ($student_questions != null) {
                    // return "test exam model ";
                    $sum_array = array(0, 0, 0, 0, 0, 0);
                    // return $sum_array[1];
                    $exam_questions = ExamStudentModule::where('exam_id', $exam->id)
                        ->where('student_id', auth()->user()->student->id)
                        ->get()->pluck('question_id');

                    $questions = $exam->questionsExams;
                    // return $exam_questions;

                    if ($questions) {

                        $collection = new Question();
                        // foreach($items as $item){
                        // $collection->push((object)['prod_id' => '99',
                        //                         'desc'=>'xyz',
                        //                         'price'=>'99',
                        //                         'discount'=>'7.35',

                        // ]);

                        //     }
                        // $questions = Question::whereIn('id' , $exam_questions)->get()->groupBy('QUESTION_TYPE_ID');
                        // foreach($exam_questions as $k => $question){
                        //     $question_object = Question::find($question);
                        //     $student_exam_questions[$question_object->QUESTION_TYPE_ID][] = $question_object ;
                        // }

                        foreach ($exam_questions as $k => $question) {
                            $question_object = Question::find($question);

                            // $collection->push((object)[
                            // 'id' => $question_object->id,
                            // 'QUESTION_TEXT'=>$question_object->QUESTION_TEXT,
                            // 'QUESTION_TYPE_ID'=>$question_object->QUESTION_TYPE_ID,
                            // 'EXAM_ID'=>$question_object->EXAM_ID,
                            // 'POINTS'=>$question_object->POINTS,
                            // 'course_id'=>$question_object->course_id,
                            // 'hard'=>$question_object->hard,
                            // 'updated_at' => $question_object->updated_at,
                            //    ]);
                            //    return $collection;
                            $student_exam_questions[$question_object->QUESTION_TYPE_ID][] = $question_object;
                            $sum_array[$question_object->QUESTION_TYPE_ID] += $question_object->POINTS;
                            // return $sum_array[$question_object->QUESTION_TYPE_ID];
                        }
                        // return $sum_array;
                        // return $student_exam_questions;
                        // return $collection;
                        $questions = $student_exam_questions;
                        // return $questions;
                        // $questions = collect($student_exam_questions);
                        $questions = collect($student_exam_questions)->map(function ($item) {
                            return (object) $item;
                        });
                        // return $questions;
                        //    return  $student_exam_questions;
                        // return $questions;
                        // $questions = $exam->questionsExams->groupBy('QUESTION_TYPE_ID');
                    }
                } else {
                    // return "testt";

                    $exam_questions = QuestionExam::where('exam_id', $exam->id)->get()->pluck('question_id');

                  
                    $questions = $exam->questionsExams;
                    if ($questions) {
                        $questions = Question::orderBy(\DB::raw('RAND()'))->whereIn('id', $exam_questions)->get();
                        $student_questions = $questions->pluck('id');
                        $questions = $questions->groupBy('QUESTION_TYPE_ID');

                        foreach ($student_questions as $question) {
                            $student_exam = new ExamStudentModule();
                            $student_exam->student_id = auth()->user()->student->id;
                            $student_exam->exam_id = $exam->id;
                            $student_exam->question_id = $question;
                            $student_exam->save();

                        }
                        // return $questions;
                    }
                }

                // return $exam_questions;
                // return $exam->randonQuestion;

                //dd($questions);
                return view('student.startExam', compact('exam', 'questions', 'start_time', 'endTime', 'time', 'sum_array'));

            } else {
                // return  $time  ;
                Log::info("start time() : " . time() . " end time " .  strtotime($endTime) );
                Log::info("start time : " .date("G:i") . " end time " . $endTime );
                Log::info("student in end time : " . auth()->user()->student->STUDENT_NAME . ' id : ' . auth()->user()->student->id );
                $answers = Stud_ques_ans_choice::where('student_id', auth()->user()->student->id)->where('exam_id', $exam->id)->get();

                $examQuestions = $exam->questionsExams;
                $total_grade = 0;
                $your_grade = 0;
                foreach ($examQuestions as $examQuestion) {
                    $total_grade += $examQuestion->POINTS;
                }

                $answers = $answers->groupBy('question_id');
                $hasAnswer = 0 ;
                foreach ($answers as $k => $answer) {
                    $hasAnswer = 1 ;
                    $question = $answer[0]->question;
                    if ($question->QUESTION_TYPE_ID == 1 || $question->QUESTION_TYPE_ID == 2) {
                        $choice = Question_choice::find($answer[0]->choice);
                        //                dd($choice);
                        //                    $question = $choice->question;
                        if ($choice->QUESTION_CHOICE_ISCORRECT) {
                            $your_grade += $question->POINTS;
                            //                    $answer->point
                            $answer[0]->point = $question->POINTS;
                            $answer[0]->save();
                        } else {
                            $answer[0]->point = 0;
                            $answer[0]->save();

                        }
                    }

                    if ($question->QUESTION_TYPE_ID == 3) {
                        $choicess = $question->choices;
                        //dd($choicess[0],$answer[0]);
                        if ($choicess[0]->QUESTION_CHOICE_TEXT == $answer[0]->choice) {
                            $your_grade += $question->POINTS;
                            if (isset($answer[1])) {
                                $answer[0]->point = $question->POINTS / 2.0;

                            } else {
                                $answer[0]->point = $question->POINTS;

                            }
                            $answer[0]->save();
                            if (isset($answer[1])) {
                                if ($choicess[1]->QUESTION_CHOICE_TEXT == $answer[1]->choice) {
                                    $answer[1]->point = $question->POINTS / 2.0;
                                    $answer[1]->save();
                                }

                            }

                        } else {
                            $answer[0]->point = 0;
                            $answer[0]->save();
                            if (isset($answer[1])) {
                                $answer[1]->point = 0;
                                $answer[1]->save();
                            }
                        }
                    }

                }
                //update

                $s = StudentExam::where('student_id', auth()->user()->student->id)->where('exam_id', $exam->id)->get()->first();
                if ($s) {
                    $s->result = $your_grade;
                    $s->save();
                } else {
                    $s = new StudentExam();
                    $s->student_id = auth()->user()->student->id;
                    $s->exam_id = $exam->id;
                    $s->result = $your_grade;
                    $s->save();
                }
                return "<h1> Out of exam time</h1><a href=" .route('student.index') ."> go to home </a>";
                // echo "<h1>" . $your_grade . "</h1>";
                // echo 'Exam Ended';
            }
        } else {
            return redirect()->route('student.index');
        }
    }

    public function answerExam(Request $request, Exam $exam)
    {
        Stud_ques_ans_choice::where('student_id', auth()->user()->student->id)->where('exam_id', $exam->id)->delete();
        
        foreach ($exam->questionsExams as $question) {
            $choices = 'choice_' . $question->id;
            if ($request->$choices) {
                foreach ($request->$choices as $ch) {
           
                    $Stud_ques_ans_choice = new Stud_ques_ans_choice();
                    $Stud_ques_ans_choice->student_id = auth()->user()->student->id;
                    $Stud_ques_ans_choice->exam_id = $exam->id;
                    $Stud_ques_ans_choice->question_id = $question->id;
                    $Stud_ques_ans_choice->choice = $ch;
                    $Stud_ques_ans_choice->save();
        

                }
            }
        }

        return redirect()->route('student.exam.result', $exam->id);
    }
    public function uploadStudentExamImage(Request $request,Exam $exam)
    {
      if(isset($request->upimage))
      {
          $studentExamImage =new StudentExamImage();
          $studentExamImage->student_id = auth()->user()->student->id;
          $studentExamImage->exam_id=$exam->id;
          $studentExamImage->path = $this->uploadImage($request->upimage);
          $studentExamImage->save();
          return $studentExamImage->path;
      }
      //return 'ok';
    }
    protected function uploadImage($file , $folderName = "exams")
    {

        $mytime = now();
        $name = $mytime->toDateTimeString() .rand().'.png';
        $name = str_replace(' ', '_', $name);
        $name = str_replace(':', '_', $name);
        $destinationPath = public_path('/'.$folderName);
        $file->move($destinationPath, $name);
      return $folderName.'/'.$name;
    }
    public function answerExamAjax(Request $request, Exam $exam)
    {
        $i = 0;
        Stud_ques_ans_choice::where('student_id', auth()->user()->student->id)->where('exam_id', $exam->id)->delete();
//        foreach ($Stud_ques_ans_choices as $r)
        //        {
        //            $r->delete();
        //        }
        //        $Stud_ques_ans_choices=Stud_ques_ans_choice::where('student_id',auth()->user()->student->id)->where('exam_id', $exam->id)->get();
        //        if($Stud_ques_ans_choices->isEmpty())
        //        {
        //            //echo 'empty';
        //        }else
        //        {
        //            foreach ($Stud_ques_ans_choices as $r)
        //            {
        //                $r->delete();
        //            }
        //        }
        foreach ($exam->questionsExams as $question) {
            $choices = 'choice_' . $question->id;
            if ($request->$choices) {
                foreach ($request->$choices as $ch) {
                    $i++;
                    $Stud_ques_ans_choice = new Stud_ques_ans_choice();
                    $Stud_ques_ans_choice->student_id = auth()->user()->student->id;
                    $Stud_ques_ans_choice->exam_id = $exam->id;
                    $Stud_ques_ans_choice->question_id = $question->id;
                    $Stud_ques_ans_choice->choice = $ch;
                    $Stud_ques_ans_choice->save();
                    echo $i . "<br>";

                }
            }
        }
    }

    public function resultExam(Exam $exam)
    {
        $answers = Stud_ques_ans_choice::where('student_id', auth()->user()->student->id)->where('exam_id', $exam->id)->get();

        $examQuestions = $exam->questionsExams;
        $total_grade = 0;
        $your_grade = 0;
        foreach ($examQuestions as $examQuestion) {
            $total_grade += $examQuestion->POINTS;
        }
        ///
        //        dd($groupExamChoices->groupBy('question_id'));

        $answers = $answers->groupBy('question_id');
//        dd($answers);

        foreach ($answers as $k => $answer) {

            $question = $answer[0]->question;
            if ($question->QUESTION_TYPE_ID == 1 || $question->QUESTION_TYPE_ID == 2) {
                $choice = Question_choice::find($answer[0]->choice);
//                dd($choice);
                //                    $question = $choice->question;
                if ($choice->QUESTION_CHOICE_ISCORRECT) {
                    $your_grade += $question->POINTS;
//                    $answer->point
                    $answer[0]->point = $question->POINTS;
                    $answer[0]->save();
                } else {
                    $answer[0]->point = 0;
                    $answer[0]->save();

                }
            }
//            dd($answer[0]);

//            dd();
            if ($question->QUESTION_TYPE_ID == 3) {
                $choicess = $question->choices;
                //dd($choicess[0],$answer[0]);
                if ($choicess[0]->QUESTION_CHOICE_TEXT == $answer[0]->choice) {
                    $your_grade += $question->POINTS;
                    if (isset($answer[1])) {
                        $answer[0]->point = $question->POINTS / 2.0;

                    } else {
                        $answer[0]->point = $question->POINTS;

                    }
                    $answer[0]->save();
                    if (isset($answer[1])) {
                        if ($choicess[1]->QUESTION_CHOICE_TEXT == $answer[1]->choice) {
                            $answer[1]->point = $question->POINTS / 2.0;
                            $answer[1]->save();
                        }

                    }

                } else {
                    $answer[0]->point = 0;
                    $answer[0]->save();
                    if (isset($answer[1])) {
                        $answer[1]->point = 0;
                        $answer[1]->save();
                    }
                }
            }

        }
        //update

        $s = StudentExam::where('student_id', auth()->user()->student->id)
        ->where('exam_id', $exam->id)->get()->first();
        if ($s) {
            $s->result = $your_grade;
            $s->save();
        } else {
            $s = new StudentExam();
            $s->student_id = auth()->user()->student->id;
            $s->exam_id = $exam->id;
            $s->result = $your_grade;
            $s->save();
        }

        return redirect()->route('student.index');
//        echo "<h1>" . $your_grade . "</h1>";
        //        $url = route('student.index');
        //        header("refresh:10;url=$url");

    }

    public function time()
    {
        date_default_timezone_set('Africa/Cairo');
        $endTime = date("G:i");
        return \Response::json($endTime);
    }

    public function timeSave(Request $request)
    {
        $time = Time::where('user_id', auth()->user()->id)->where('exam_id', $request->exam_id)->first();
        if ($time) {
            $time->user_id = auth()->user()->id;
            $time->time = $request->time;
            $time->exam_id = $request->exam_id;
            $time->save();
        } else {
            $time = new Time();
            $time->user_id = auth()->user()->id;
            $time->exam_id = $request->exam_id;
            $time->time = $request->time;
            $time->enddate = $request->enddate;

            $time->save();
        }

        //date_default_timezone_set('Africa/Cairo');
        //$endTime = date("G:i");
        //return \Response::json( $endTime );
    }

}
