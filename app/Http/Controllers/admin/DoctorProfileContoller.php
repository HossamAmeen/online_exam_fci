<?php

namespace App\Http\Controllers\admin;

use App\Course;
use App\Exam;
use App\Faculty;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorProfileRequest;
use App\Ilos;
use App\Question;
use App\Question_choice;
use App\Question_ilos;
use App\QuestionExam;
use App\Staff;
use App\Stud_ques_ans_choice;
use App\Student;
use App\QuestionImage;
use App\ChooseImage;
use App\Student_cource_exam;
use App\StudentExam;
use App\StudentExamImage;
use Illuminate\Http\Request;
use Excel;
use App\Imports\QuestionImport;
class DoctorProfileContoller extends Controller
{
    public function index()
    {

        $exams = Exam::where('STAFF_ID', auth()->user()->staff->id)->get();
        return view('doctor.index', compact('exams'));
    }

    public function createExam()
    {
        $faculites = Faculty::all();
        $staffs = Staff::all();
        return view('doctor.createExam', compact('faculites', 'staffs'));
    }

    public function showExam(Exam $exam)
    {
        $questions = $exam->questionsExams;
        if (!$questions->isEmpty()) {
            $questions = $exam->questionsExams->groupBy('QUESTION_TYPE_ID');
        }
        // return $questions;
        return view('doctor.startExam', compact('exam', 'questions'));

    }

    public function printExam(Exam $exam)
    {
        $questions = $exam->questionsExams;
        if (!$questions->isEmpty()) {
            $questions = $exam->questionsExams->groupBy('QUESTION_TYPE_ID');
        }
        // return $questions;
        return view('doctor.printExam', compact('exam', 'questions'));

    }
    public function printExamHardnessReportPDF(Exam $exam)
    {
        $questions = $exam->questionsExams;
        $data = array();
        foreach($questions as $question){

          //$studentQuestions  =  Stud_ques_ans_choice::where('question_id' ,$question->id )->where('exam_id' , $exam->id)->get();
          // $datas['total'] = $studentQuestions->count();
            $cards = \DB::select("select ( SELECT count(*) from
            stud_ques_ans_choices where stud_ques_ans_choices.question_id=$question->id and stud_ques_ans_choices.exam_id=$exam->id) as total
           ,(select count(*) from stud_ques_ans_choices,questions WHERE stud_ques_ans_choices.question_id=questions.id
           AND stud_ques_ans_choices.question_id=$question->id
           and stud_ques_ans_choices.exam_id=$exam->id and stud_ques_ans_choices.point=questions.POINTS) as correct");
        //$data[$question->id]['total'] = $cards[0]->total;
        //$data[$question->id]['correct'] = $cards[0]->correct;
        $data[$question->id]['hardness'] = (($cards[0]->correct*1.0)/$cards[0]->total)*100;
        $data[$question->id]['diff'] = $cards[0]->correct/$cards[0]->total;

        }
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(view('doctor.printExamHardnessReport', compact('exam','questions', 'data'))->render());
      $mpdf->Output('Exam Hardness Report_'.$exam->EXAM_NAME.'.pdf','D');
      exit;
        // return $data;


    }

    public function printExamHardnessReport(Exam $exam)
    {
          //compute differntiate factor
          $student_cource_exam = StudentExam::where('exam_id', $exam->id)->get();
          $studentsrank=array();
          foreach ($student_cource_exam as $s) {
    //            dd($s->exam);
              $stud_ques_ans_choices = Stud_ques_ans_choice::where('exam_id', $exam->id)->where('student_id', $s->student->id)->get();

              $studentsrank[$s->student->id]=($s->Total_Student_Score + $stud_ques_ans_choices->sum('point'));

          }

          arsort($studentsrank);


        $questions = $exam->questionsExams;
        $data = array();
        foreach($questions as $question){

          //$studentQuestions  =  Stud_ques_ans_choice::where('question_id' ,$question->id )->where('exam_id' , $exam->id)->get();
          // $datas['total'] = $studentQuestions->count();
            $cards = \DB::select("select ( SELECT count(*) from
            stud_ques_ans_choices where stud_ques_ans_choices.question_id=$question->id and stud_ques_ans_choices.exam_id=$exam->id) as total
           ,(select count(*) from stud_ques_ans_choices,questions WHERE stud_ques_ans_choices.question_id=questions.id
           AND stud_ques_ans_choices.question_id=$question->id
           and stud_ques_ans_choices.exam_id=$exam->id and stud_ques_ans_choices.point=questions.POINTS) as correct");
        //$data[$question->id]['total'] = $cards[0]->total;
        //$data[$question->id]['correct'] = $cards[0]->correct;
        $data[$question->id]['hardness'] = (($cards[0]->correct*1.0)/$cards[0]->total)*100;

        //compute differntiate factor
        $quarterelementsnumber=(int)((count($studentsrank)*27.0)/100);

        //top 27% quarater
        $topranks=array_slice($studentsrank,0,$quarterelementsnumber);
        $correctst=0;
        foreach($topranks as $sid=>$sr)
        {
          $card=\DB::select("select (select count(*) from stud_ques_ans_choices WHERE stud_ques_ans_choices.question_id=$question->id
          and stud_ques_ans_choices.exam_id=$exam->id and stud_ques_ans_choices.student_id=$sid AND stud_ques_ans_choices.point=questions.POINTS) as correct");
          if($card[0]->correct>0)
            $correctst+=1;
        }
        $toppercent=0;
        if(count($topranks)>0)
          $toppercent=($correctst*1.0/count($topranks));

        $bottomtranks= array_slice($studentsrank,-1*$quarterelementsnumber,$quarterelementsnumber);
        $correctst=0;
        foreach($bottomtranks as $sid=>$sr)
        {
          $card=\DB::select("select (select count(*) from stud_ques_ans_choices WHERE stud_ques_ans_choices.question_id=$question->id
          and stud_ques_ans_choices.exam_id=$exam->id and stud_ques_ans_choices.student_id=$sid AND stud_ques_ans_choices.point=questions.POINTS) as correct");
          if($card[0]->correct>0)
            $correctst+=1;
        }
        $bottompercent=0;
        if(count($bottomtranks)>0)
        $bottompercent=($correctst*1.0/count($bottomtranks));


        $data[$question->id]['diff'] = $toppercent-$bottompercent;

        }
          return view('doctor.printExamHardnessReport', compact('exam','questions', 'data'));
        // return $data;
        //return view('doctor.printExamHardnessReport', compact('exam','questions', 'data'));

    }
    public function getTopQuarterRank($studentsrank,$exam,$question)
    {
      $quarterelementsnumber=(int)((count($studentsrank)*27.0)/100);
      $toptranks=array_slice($studentsrank,0,$quarterelementsnumber);
      $correctst=0;
      foreach($topranks as $sid=>$sr)
      {
        $card=\DB::select("select (select count(*) from stud_ques_ans_choices WHERE stud_ques_ans_choices.question_id=$question->id
        and stud_ques_ans_choices.exam_id=$exam->id and stud_ques_ans_choices.student_id=$sid AND stud_ques_ans_choices.point=questions.POINTS) as correct");
        if($card[0]->correct>0)
          $correctst+=1;
      }

      if(count($topranks)==0)
        return 0;
      else
        return ($correctst*1.0/count($topranks));
    }
    public function getBottomQuarterRank($studentsrank)
    {
      $quarterelementsnumber=(int)((count($studentsrank)*27.0)/100);
      $bottomtranks= array_slice($studentsrank,-1*$quarterelementsnumber,$quarterelementsnumber);
      $correctst=0;
      foreach($bottomtranks as $sid=>$sr)
      {
        $card=\DB::select("select (select count(*) from stud_ques_ans_choices WHERE stud_ques_ans_choices.question_id=$question->id
        and stud_ques_ans_choices.exam_id=$exam->id and stud_ques_ans_choices.student_id=$sid AND stud_ques_ans_choices.point=questions.POINTS) as correct");
        if($card[0]->correct>0)
          $correctst+=1;
      }
      if(count($bottomtranks)==0)
        return 0;
      else
      return ($correctst*1.0/count($bottomtranks));
    }
    public function printExamIlosReport(Exam $exam)
    {
        $examilos = \DB::select("SELECT Distinct ilos.* from ilos,question_ilos,questions,stud_ques_ans_choices where ilos.id=question_ilos.ILO_ID AND question_ilos.QUESTION_ID=Questions.id and questions.id=stud_ques_ans_choices.question_id and stud_ques_ans_choices.exam_id=$exam->id");
        $data = array();
        foreach($examilos as $ilo){
          $iloobject = json_decode(json_encode($ilo), FALSE);
          //$studentQuestions  =  Stud_ques_ans_choice::where('question_id' ,$question->id )->where('exam_id' , $exam->id)->get();
          // $datas['total'] = $studentQuestions->count();
            $cards = \DB::select("select ( SELECT count(*) from
            ilos,question_ilos,questions,stud_ques_ans_choices where ilos.id=question_ilos.ILO_ID AND question_ilos.QUESTION_ID=questions.id AND questions.id=stud_ques_ans_choices.question_id AND ilos.id=$iloobject->id and stud_ques_ans_choices.exam_id=$exam->id) as total
           ,(select count(*) from ilos,question_ilos,questions,stud_ques_ans_choices where ilos.id=question_ilos.ILO_ID AND question_ilos.QUESTION_ID=questions.id AND
          questions.id=stud_ques_ans_choices.question_id and ilos.id=$iloobject->id
           and stud_ques_ans_choices.exam_id=$exam->id and stud_ques_ans_choices.point=questions.POINTS) as correct");
        //$data[$question->id]['total'] = $cards[0]->total;
        //$data[$question->id]['correct'] = $cards[0]->correct;
        $data[$iloobject->id]['ilospercent'] = (int)((($cards[0]->correct*1.0)/$cards[0]->total)*100);
        //$data[$iloobject->id]['ilospercent'] =$iloobject->id.'/'. $exam->id.'/'.$cards[0]->correct.'/'.$cards[0]->total;

        }

        // return $data;
        return view('doctor.printExamIlosReport', compact('exam','examilos', 'data'));

    }
    public function printExamIlosReportPDF(Exam $exam)
    {
        $examilos = \DB::select("SELECT Distinct ilos.* from ilos,question_ilos,questions,stud_ques_ans_choices where ilos.id=question_ilos.ILO_ID AND question_ilos.QUESTION_ID=Questions.id and questions.id=stud_ques_ans_choices.question_id and stud_ques_ans_choices.exam_id=$exam->id");
        $data = array();
        foreach($examilos as $ilo){
          $iloobject = json_decode(json_encode($ilo), FALSE);
          //$studentQuestions  =  Stud_ques_ans_choice::where('question_id' ,$question->id )->where('exam_id' , $exam->id)->get();
          // $datas['total'] = $studentQuestions->count();
            $cards = \DB::select("select ( SELECT count(*) from
            ilos,question_ilos,questions,stud_ques_ans_choices where ilos.id=question_ilos.ILO_ID AND question_ilos.QUESTION_ID=questions.id AND questions.id=stud_ques_ans_choices.question_id AND ilos.id=$iloobject->id and stud_ques_ans_choices.exam_id=$exam->id) as total
           ,(select count(*) from ilos,question_ilos,questions,stud_ques_ans_choices where ilos.id=question_ilos.ILO_ID AND question_ilos.QUESTION_ID=questions.id AND
          questions.id=stud_ques_ans_choices.question_id and ilos.id=$iloobject->id
           and stud_ques_ans_choices.exam_id=$exam->id and stud_ques_ans_choices.point=questions.POINTS) as correct");
        //$data[$question->id]['total'] = $cards[0]->total;
        //$data[$question->id]['correct'] = $cards[0]->correct;
        $data[$iloobject->id]['ilospercent'] = (int)((($cards[0]->correct*1.0)/$cards[0]->total)*100);
        }

        // return $data;
        //return view('doctor.printExamIlosReport', compact('exam','examilos', 'data'));
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(view('doctor.printExamIlosReport', compact('exam','examilos', 'data'))->render());
      $mpdf->Output('Exam Ilos Report_'.$exam->EXAM_NAME.'.pdf','D');

    }
    public function uploadQuestionExcel(Request $request)
    {

        session(['course_id' => $request->course_id]);
        if(isset($request->exam_id)) session(['exam_id' => $request->exam_id ]);

        Excel::import(new QuestionImport, request()->file('question_sheet'));

        $request->session()->forget(['course_id', 'exam_id']);
        return redirect()->route('doctorProfile.question.createBank');

    }
    public function editExam(Exam $exam)
    {
//        dd($exam);
        return view('doctor.editExam', compact('exam'));

    }

    public function updateExam(Request $request, Exam $exam)
    {
        $exam->EXAM_NAME = $request->name;
        $exam->type = $request->type;
        $exam->EXAM_TOTAL = $request->point;
        $exam->time = $request->start_time;
        $exam->allow_time = $request->allow_time;
        $exam->date = $request->date;
        $exam->end_date = $request->end_date;
        $exam->EXAM_DURATION = $request->time;
        $exam->COURSE_ID = $request->course_id;
        $exam->STAFF_ID = auth()->user()->staff->id;
        if(isset($request->camerarequired))
        {
          $exam->camera_required=1;
        }else {
          $exam->camera_required=0;
        }
        $exam->number_choose_easy_question = $request->number_choose_easy_question;
        $exam->number_choose_meduim_question = $request->number_choose_meduim_question;
        $exam->number_choose_hard_question = $request->number_choose_hard_question;
        $exam->number_true_and_false_easy_question = $request->number_true_and_false_easy_question;
        $exam->number_true_and_false_meduim_question = $request->number_true_and_false_meduim_question;
        $exam->number_true_and_false_hard_question = $request->number_true_and_false_hard_question;
        $exam->number_write_code_easy_question = $request->number_write_code_easy_question;
        $exam->number_write_code_meduim_question = $request->number_write_code_meduim_question;
        $exam->number_write_code_hard_question = $request->number_write_code_hard_question;
        $exam->number_complete_easy_question = $request->number_complete_easy_question;
        $exam->number_complete_meduim_question = $request->number_complete_meduim_question;
        $exam->number_complete_hard_question = $request->number_complete_hard_question;
        $exam->number_define_easy_question = $request->number_define_easy_question;
        $exam->number_define_meduim_question = $request->number_define_meduim_question;
        $exam->number_define_hard_question = $request->number_define_hard_question;
        $exam->save();
        return redirect()->route('doctorProfile.index');
    }

    public function storeExam(DoctorProfileRequest $request)
    {

        $exam = new Exam();
        $exam->EXAM_NAME = $request->name;
        $exam->type = $request->type;
        $exam->EXAM_TOTAL = $request->point;
        $exam->time = $request->start_time;
        $exam->allow_time = $request->allow_time;
        $exam->date = $request->date;
        $exam->end_date = $request->end_date;
        $exam->EXAM_DURATION = $request->time;
        $exam->COURSE_ID = $request->course_id;
        $exam->STAFF_ID = auth()->user()->staff->id;
        if(isset($request->camerarequired))
        $exam->camera_required=1;
        // $exam->number_easy_question = $request->number_easy_question;
        // $exam->number_medium_question = $request->number_medium_question;
        // $exam->number_hard_question = $request->number_hard_question;

        // $exam->number_choose_question = $request->number_choose_question;
        // $exam->number_true_and_false = $request->number_true_and_false;
        // $exam->number_complete_question = $request->number_complete_question;
        // $exam->number_write_code_question = $request->number_write_code_question;
        // $exam->number_define_question = $request->number_define_question;
        $exam->number_choose_easy_question = $request->number_choose_easy_question;
        $exam->number_choose_meduim_question = $request->number_choose_meduim_question;
        $exam->number_choose_hard_question = $request->number_choose_hard_question;
        $exam->number_true_and_false_easy_question = $request->number_true_and_false_easy_question;
        $exam->number_true_and_false_meduim_question = $request->number_true_and_false_meduim_question;
        $exam->number_true_and_false_hard_question = $request->number_true_and_false_hard_question;
        $exam->number_write_code_easy_question = $request->number_write_code_easy_question;
        $exam->number_write_code_meduim_question = $request->number_write_code_meduim_question;
        $exam->number_write_code_hard_question = $request->number_write_code_hard_question;
        $exam->number_complete_easy_question = $request->number_complete_easy_question;
        $exam->number_complete_meduim_question = $request->number_complete_meduim_question;
        $exam->number_complete_hard_question = $request->number_complete_hard_question;
        $exam->number_define_easy_question = $request->number_define_easy_question;
        $exam->number_define_meduim_question = $request->number_define_meduim_question;
        $exam->number_define_hard_question = $request->number_define_hard_question;
        $exam->save();
      
        ///update all student records
        $Student_cource_exams = Student_cource_exam::where('COURSE_ID', $request->course_id)->whereNull('EXAM_ID')->get();
        //dd($Student_cource_exams,$request->course_id);
        foreach ($Student_cource_exams as $kk) {
            $kk->EXAM_ID = $exam->id;
            $kk->save();
        }
        return redirect()->route('doctorProfile.index');

    }


    public function createQuestion(Exam $exam)
    {

        $questions_lists = $exam->questionsExams;

        //        dd($exam,$exam->questionsExams);
        $ilos = Ilos::where('COURSE_ID', $exam->COURSE_ID)->get();
        /////////////////////////
        $questions=Question::where('course_id',$exam->COURSE_ID)->get();
        //        dd();

        return view('doctor.createQuestion', compact('questions','exam', 'ilos', 'questions_lists'));

    }
    public function createBankQuestion(){

        //        dd($exam,$exam->questionsExams);
        //        dd(1);
        ////////////    /////////////
        // return "test";
        $ilos = Ilos::whereIn('COURSE_ID', auth()->user()->staff->courses->pluck('id'))->get();


        $questions=Question::whereIn('course_id',auth()->user()->staff->courses->pluck('id'))->get();

        $questions_lists = $questions;
        $course_id=1;
      //dd(isset($course_id));
        return view('doctor.createQuestion', compact('questions','course_id', 'ilos', 'questions_lists'));
    }
    public function StoreBankQuestion(Request $request)
    {

        //        $exam=Exam::find($request->exam_id);
        // return $request->all();
        if($request->choose==1)
        {

        }else{

            $question = new Question();
            $question->QUESTION_TYPE_ID = $request->question_type;
            //            $question->EXAM_ID = $request->exam_id;
            $question->course_id=$request->course_id;
            $question->POINTS = $request->point;
            $question->hard=$request->hard;
            if ($request->question_type == 1) {
                $question->QUESTION_TEXT = $request->name1;
                $question->save();
                //            `QUESTION_ID`, `QUESTION_CHOICE_TEXT`, `QUESTION_CHOICE_ISCORRECT`
                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[0];
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 1 ? 1 : 0;
                $question_choice->save();

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[1];
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 2 ? 1 : 0;
                $question_choice->save();

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[2];
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 3 ? 1 : 0;
                $question_choice->save();

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[3];
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 4 ? 1 : 0;
                $question_choice->save();

            }
            if ($request->question_type == 2) {
                $question->QUESTION_TEXT = $request->name2;
                $question->save();
                //            `QUESTION_ID`, `QUESTION_CHOICE_TEXT`, `QUESTION_CHOICE_ISCORRECT`
            
         
                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = 'True';
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_true_false;
                $question_choice->save();

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = 'False';
                $question_choice->QUESTION_CHOICE_ISCORRECT = !$request->choose_true_false;
                $question_choice->save();

            }
            if ($request->question_type == 3) {
                $question->QUESTION_TEXT = $request->name3;
                $question->save();

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->complete_1;
                $question_choice->save();

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->complete_2;
                $question_choice->save();

            }
            if ($request->question_type == 4) {
                $question->QUESTION_TEXT = $request->name4;
                $question->save();
            }
            if ($request->question_type == 5) {
                $question->QUESTION_TEXT = $request->name5;
                $question->save();
            }

            if(isset($request->ilos))
            {
            foreach ($request->ilos as $ilo) {
                $i = new Question_ilos();
                $i->QUESTION_ID = $question->id;
                $i->ILO_ID = $ilo;
                $i->save();

            }
            }
            //            $questionexam=new QuestionExam();
            //            $questionexam->question_id=$question->id;
            //            $questionexam->exam_id=$exam->id;
            //            $questionexam->save();

        }
        session()->flash('questions' , "add new question successfully");
        return back();
    }

    protected function uploadImage($file , $folderName = "images")
    {

        $mytime = now();
        $name = $mytime->toDateTimeString() .rand().'.'.$file->getClientOriginalExtension();
        $name = str_replace(' ', '_', $name);
        $name = str_replace(':', '_', $name);
        $destinationPath = public_path('/'.$folderName);
        $file->move($destinationPath, $name);
      return $folderName.'/'.$name;
    }

    public function storeQuestion(Request $request)
    {

        $exam=Exam::find($request->exam_id);

        if($request->choose==1)
        {

            $questionexam=new QuestionExam();
            $questionexam->question_id=$request->question_id;
            $questionexam->exam_id=$exam->id;
            $questionexam->save();

        }else{

            $question = new Question();
            $question->QUESTION_TYPE_ID = $request->question_type;
            $question->EXAM_ID = $request->exam_id;
            $question->course_id=$exam->COURSE_ID;
            $question->POINTS = $request->point;
            $question->hard=$request->hard;
            // return $request->question_type ;
            if ($request->question_type == 1) {


                $question->QUESTION_TEXT = $request->name1;
                $question->save();
                if(isset($request->question_image))
                {
                    $questionImage =new QuestionImage();
                    $questionImage->question_id = $question->id;
                    $questionImage->path = $this->uploadImage($request->question_image);
                    $questionImage->save();
                }
             // return "Test";
        //            `QUESTION_ID`, `QUESTION_CHOICE_TEXT`, `QUESTION_CHOICE_ISCORRECT`
                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[0];
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 1 ? 1 : 0;
                $question_choice->save();

                if(isset($request->choose_image))
                {
                    $questionImage =new ChooseImage();
                    $questionImage->question_choice_id = $question_choice->id;
                    $questionImage->path = $this->uploadImage($request->choose_image , "choose");
                    $questionImage->save();
                }
                /////////////// choose 2
                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[1];
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 2 ? 1 : 0;
                $question_choice->save();
                if(isset($request->choose_image_2))
                {
                    $questionImage =new ChooseImage();
                    $questionImage->question_choice_id = $question_choice->id;
                    $questionImage->path = $this->uploadImage($request->choose_image_2 , "choose");
                    $questionImage->save();
                }
                ////////////// choose 3
                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[2];
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 3 ? 1 : 0;
                $question_choice->save();
                if(isset($request->choose_image_3))
                {
                    $questionImage =new ChooseImage();
                    $questionImage->question_choice_id = $question_choice->id;
                    $questionImage->path = $this->uploadImage($request->choose_image_3 , "choose");
                    $questionImage->save();
                }
                /////////////////// choose 4
                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[3];
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 4 ? 1 : 0;
                $question_choice->save();
                if(isset($request->choose_image_4))
                {
                    $questionImage =new ChooseImage();
                    $questionImage->question_choice_id = $question_choice->id;
                    $questionImage->path = $this->uploadImage($request->choose_image_4 , "choose");
                    $questionImage->save();
                }

            }
            if ($request->question_type == 2) {
                $question->QUESTION_TEXT = $request->name2;
                $question->save();
              if(isset($request->question_image))
                {
                    $questionImage =new QuestionImage();
                    $questionImage->question_id = $question->id;
                    $questionImage->path = $this->uploadImage($request->question_image);
                    $questionImage->save();
                }
        //            `QUESTION_ID`, `QUESTION_CHOICE_TEXT`, `QUESTION_CHOICE_ISCORRECT`
                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = 'True';
                $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_true_false;
                $question_choice->save();

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = 'False';
                $question_choice->QUESTION_CHOICE_ISCORRECT = !$request->choose_true_false;
                $question_choice->save();

            }
            if ($request->question_type == 3) {
                $question->QUESTION_TEXT = $request->name3;
                $question->save();
              if(isset($request->question_image))
                {
                    $questionImage =new QuestionImage();
                    $questionImage->question_id = $question->id;
                    $questionImage->path = $this->uploadImage($request->question_image);
                    $questionImage->save();
                }

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->complete_1;
                $question_choice->save();

                $question_choice = new Question_choice();
                $question_choice->QUESTION_ID = $question->id;
                $question_choice->QUESTION_CHOICE_TEXT = $request->complete_2;
                $question_choice->save();

            }
            if ($request->question_type == 4) {
                $question->QUESTION_TEXT = $request->name4;
                $question->save();
              if(isset($request->question_image))
                {
                    $questionImage =new QuestionImage();
                    $questionImage->question_id = $question->id;
                    $questionImage->path = $this->uploadImage($request->question_image);
                    $questionImage->save();
                }
            }
            if ($request->question_type == 5) {
                $question->QUESTION_TEXT = $request->name5;
                $question->save();
              if(isset($request->question_image))
                {
                    $questionImage =new QuestionImage();
                    $questionImage->question_id = $question->id;
                    $questionImage->path = $this->uploadImage($request->question_image);
                    $questionImage->save();
                }
            }

            // return $request->ilos ;
          if(isset($request->ilos))
          {  foreach ($request->ilos as $ilo) {
                $i = new Question_ilos();
                $i->QUESTION_ID = $question->id;
                $i->ILO_ID = $ilo;
                $i->save();

            }
          }
            $questionexam=new QuestionExam();
            $questionexam->question_id=$question->id;
            $questionexam->exam_id=$exam->id;
            $questionexam->save();

        }

        return back();
        //$ilos=Ilos::where('COURSE_ID',$exam->COURSE_ID)->get();

        // return view('doctor.createQuestion',compact('exam','ilos'));

    }

    public function editQuestion(Question $question,Exam $exam = null)
    {
            //        dd($question,$exam);
        // $questions_lists = $exam->questionsExams;
        $ilos = Ilos::where('COURSE_ID', $question->course_id)->get();
        // return view('doctor.editQuestion', compact('ilos', 'questions_lists', 'question','exam'));
        return view('doctor.editQuestion', compact('ilos', 'question','exam'));
    }
    public function deleteBankQuestion(Question $question)
    {
        $question->delete();
        return redirect()->back();

    }

    public function updateQuestion(Request $request, Question $question)
    {
        if (!$question->choices->isEmpty()) {
            foreach ($question->choices as $c) {
                $c->delete();
            }
        }
        //        dd('sad');

        if (!$question->ilos->isEmpty()) {
            foreach ($question->ilos as $i) {
                $i->delete();
            }
        }
        //        dd();
                //if()
                //$question->delete();
                //$question = new Question();
        $question->QUESTION_TYPE_ID = $request->question_type;
        //        $question->EXAM_ID = $request->exam_id;
        $question->POINTS = $request->point;
        $question->hard=$request->hard;

        if ($request->question_type == 1) {
            $question->QUESTION_TEXT = $request->name1;
            $question->save();
            //            `QUESTION_ID`, `QUESTION_CHOICE_TEXT`, `QUESTION_CHOICE_ISCORRECT`
            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[0];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 1 ? 1 : 0;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[1];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 2 ? 1 : 0;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[2];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 3 ? 1 : 0;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $request->choose_text[3];
            $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_answer_1 == 4 ? 1 : 0;
            $question_choice->save();

        }
        if ($request->question_type == 2) {
            $question->QUESTION_TEXT = $request->name2;
            $question->save();
            //            `QUESTION_ID`, `QUESTION_CHOICE_TEXT`, `QUESTION_CHOICE_ISCORRECT`
           
            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = 'True';
            $question_choice->QUESTION_CHOICE_ISCORRECT = $request->choose_true_false;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = 'False';
            $question_choice->QUESTION_CHOICE_ISCORRECT = !$request->choose_true_false;
            $question_choice->save();

        }
        if ($request->question_type == 3) {
            $question->QUESTION_TEXT = $request->name3;
            $question->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $request->complete_1;
            $question_choice->save();

            $question_choice = new Question_choice();
            $question_choice->QUESTION_ID = $question->id;
            $question_choice->QUESTION_CHOICE_TEXT = $request->complete_2;
            $question_choice->save();

        }
        if ($request->question_type == 4) {
            $question->QUESTION_TEXT = $request->name4;
            $question->save();
        }
        if ($request->question_type == 5) {
            $question->QUESTION_TEXT = $request->name5;
            $question->save();
        }


        foreach ($request->ilos as $ilo) {
            $i = new Question_ilos();
            $i->QUESTION_ID = $question->id;
            $i->ILO_ID = $ilo;
            $i->save();

        }
        //dd($request->all(),$question);
        return redirect()->route('doctorProfile.index');
    }

    public function deleteQuestion(Question $question,Exam $exam)
    {
        QuestionExam::where('question_id',$question->id)->where('exam_id',$exam->id)->get()->first()->delete();
        return redirect()->back();


    }

    public function showExamResult()
    {
        $exams = Exam::where('STAFF_ID', auth()->user()->staff->id)->get();
        return view('doctor.showExams', compact('exams'));
    }

    public function showExamResultDetial(Request $request)
    {
        $student_cource_exam = StudentExam::where('exam_id', $request->id)->get();
        //        dd($student_cource_exam);
      $str= '<div class="editable-responsive"> <table class="table table-striped" id="datatable-editable"><tr>
                 <th>Student</th>
                 <th>Course</th>
                 <th>Question</th>
                 <th>Images</th>
                 <th>Total</th>
                 <th><a href="' . route('doctorProfile.exam.downloadallpdf', $request->id) . '" >Download All</a></th>
                </tr>';
        foreach ($student_cource_exam as $s) {
            //            dd($s->exam);
            $stud_ques_ans_choices = Stud_ques_ans_choice::where('exam_id', $request->id)->where('student_id', $s->student->id)->get();
            //            dd($stud_ques_ans_choices);
            $str .= '<tr>
                    <td>' . $s->student->STUDENT_NAME . '</td>
                    <td>' . $s->exam->course->COURSE_NAME . '</td>
                    <td><a href="' . route('doctorProfile.exam.question', [$s->exam_id, $s->student->id, $s->exam->course->id]) . '" >Questions</a></Th>
                    <td><a href="' . route('doctorProfile.exam.studentimages', [$s->exam_id, $s->student->id]) . '" >Images</a></Th>
                    <td>' . ($s->Total_Student_Score + $stud_ques_ans_choices->sum('point')) . '</td>
                    <td><a href="' . route('doctorProfile.exam.downloadpdf', [$s->exam_id, $s->student->id, $s->exam->course->id]) . '" >PDF</a></td>
                </tr>';
        }

        $str .= '</table></div>';

        return $str;
    }
    public function downloadStudentExamPDF(Exam $exam, Student $student, Course $course)
    {
      $stud_ques_ans_choices = Stud_ques_ans_choice::where('exam_id', $exam->id)->where('student_id', $student->id)->get();
        //        dd($stud_ques_ans_choices);
      //$pdf=\MPDF::loadview('doctor.showQuestionsPDF', compact('stud_ques_ans_choices', 'exam', 'student', 'course', 'questions'));
     //return $pdf->download($course->COURSE_NAME.'_'.$exam->EXAM_NAME.'_'.$student->STUDENT_NAME.'_'.$student->STUDENT_SSN.'.pdf');

     //return view('doctor.showQuestionsPDF', compact('stud_ques_ans_choices', 'exam', 'student', 'course', 'questions'));
      $mpdf = new \Mpdf\Mpdf();
      $mpdf->WriteHTML(view('doctor.showQuestionsPDF', compact('stud_ques_ans_choices', 'exam', 'student', 'course'))->render());
      $mpdf->Output($course->COURSE_NAME.'_'.$exam->EXAM_NAME.'_'.$student->STUDENT_NAME.'_'.$student->STUDENT_SSN.'.pdf','D');
     exit;
    }
    public function downloadAllStudentsExamPDF(Exam $exam)
    {

      error_reporting(E_ALL & ~E_NOTICE);
       $zip = new \ZipArchive();
       $zipFile = tempnam('/tmp', 'zip');
       $zip->open($zipFile, \ZipArchive::CREATE);
         $student_cource_exam = StudentExam::where('exam_id', $exam->id)->get();
         $course=$exam->course;
         foreach ($student_cource_exam as $s)
         {
             $mpdf = new \Mpdf\Mpdf();
           $stud_ques_ans_choices = Stud_ques_ans_choice::where('exam_id', $exam->id)->where('student_id', $s->student->id)->get();
           $student=$s->student;
           $mpdf->WriteHTML(view('doctor.showQuestionsPDF', compact('stud_ques_ans_choices', 'exam', 'student', 'course', 'questions'))->render());
           $pdfData = $mpdf->Output("", \Mpdf\Output\Destination::STRING_RETURN);
           $zip->addFromString($course->COURSE_NAME.'_'.$exam->EXAM_NAME.'_'.$student->STUDENT_NAME.'_'.$student->STUDENT_SSN.'.pdf', $pdfData);
         }


       $zip->close();

       header("Content-type: application/zip");
       header('Content-Disposition: attachment; filename='.$course->COURSE_NAME.'_'.$exam->EXAM_NAME.'.zip');
       readfile($zipFile);

       unlink($zipFile);
       exit;
    }
    public function downloadResult(Exam $exam)
    {
        $arr=[];
        $arr[]=['Student','Total'];
        $student_cource_exam = StudentExam::where('exam_id', $exam->id)->get();
        //        dd($student_cource_exam);
        //        $str = '<table class="table table-responsive table-bordered table-striped"><tr>
        //                 <th>Student</th>
        //                 <th>Course</th>
        //                 <th>Question</th>
        //                 <th>Total</th>
        //                </tr>';
        foreach ($student_cource_exam as $s) {
        //            dd($s->exam);
            $stud_ques_ans_choices = Stud_ques_ans_choice::where('exam_id', $exam->id)->where('student_id', $s->student->id)->get();
        //            dd($stud_ques_ans_choices);
        //            $str .= '<tr>
        //                    <th>' . $s->student->STUDENT_NAME . '</th>
        //                    <th>' . $s->exam->course->COURSE_NAME . '</th>
        //                    <Th><a href="' . route('doctorProfile.exam.question', [$s->exam_id, $s->student->id, $s->exam->course->id]) . '" >Questions</a></Th>
        //                    <th>' . ($s->Total_Student_Score + $stud_ques_ans_choices->sum('point')) . '</th>
        //                </tr>';
            $arr[]=[$s->student->STUDENT_NAME ,($s->Total_Student_Score + $stud_ques_ans_choices->sum('point')) ];
        }

        //        $str .= '</table>';
        //        return $str;
        //        dd($arr);
        return Excel::create($exam->EXAM_NAME.'-'.$exam->course->COURSE_NAME, function($excel) use ($arr) {
            $excel->sheet('mySheet', function($sheet) use ($arr)
            {
                $sheet->fromArray($arr);
            });
        })->download('xlsx');
    }

    public function showExamQuestion(Exam $exam, Student $student, Course $course)
    {
       
        $stud_ques_ans_choices = Stud_ques_ans_choice::where('exam_id', $exam->id)->where('student_id', $student->id)->get();
        //        dd($stud_ques_ans_choices);
        return view('doctor.showQuestions', compact('stud_ques_ans_choices', 'exam', 'student', 'course'));
    }

    public function showExamStudentImages(Exam $exam, Student $student)
    {
      $studentExamImageslist=StudentExamImage::where('exam_id', $exam->id)->where('student_id', $student->id)->get();
      return view('doctor.showExamStudentImages', compact('studentExamImageslist', 'exam', 'student'));

    }
    public function storeGradeQuestion(Request $request)
    {
        // dd($request->all());
        foreach ($request->stud_ques as $k => $id) {
            $Stud_ques_ans_choice = Stud_ques_ans_choice::find($id);
            $Stud_ques_ans_choice->point = $request->grades[$k];
            $Stud_ques_ans_choice->save();

        }
        return redirect()->back();
    }

    public function calculateExam(Exam $exam)
    {
        $students = Stud_ques_ans_choice::where('exam_id', $exam->id)->get()->groupby('student_id');

        foreach ($students as $student=>$answers)
        {
            $examQuestions = $exam->questionsExams;
            $total_grade = 0;
            $your_grade = 0;
            foreach ($examQuestions as $examQuestion) {
                $total_grade += $examQuestion->POINTS;
            }
            $answers = $answers->groupBy('question_id');
            foreach ($answers as $k => $answer) {

                $question = $answer[0]->question;
                if ($question->QUESTION_TYPE_ID == 1 || $question->QUESTION_TYPE_ID == 2) {
                    $choice = Question_choice::find($answer[0]->choice);
                    if ($choice->QUESTION_CHOICE_ISCORRECT) {
                        $your_grade += $question->POINTS;
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
            $s = StudentExam::where('student_id', $student)->where('exam_id', $exam->id)->get()->first();
            if ($s) {
                $s->result = $your_grade;
                $s->save();
            } else {
                $s = new StudentExam();
                $s->student_id = $student;
                $s->exam_id = $exam->id;
                $s->result = $your_grade;
                $s->save();
            }
        }

        return redirect()->back();

    }
    public function reopen(Exam $exam)
    {
        $studentExams = StudentExam::where('exam_id', $exam->id)->get();
        //        dd($studentExams);
        return view('doctor.reopen',compact('studentExams'));
    }
    public function reopenExam(StudentExam $studentExam)
    {
        $studentExam->delete();
        return redirect()->back();


    }
    public function ilosresult(Exam $exam)
    {
        $count=$exam->studentExams->count();

        $ilos=[];
        $ilos_name=[];
        $questions=[];
        $examQuestions = $exam->questionsExams;
        foreach ($examQuestions as $examQuestion) {
            if($examQuestion->QUESTION_TYPE_ID==1 ||$examQuestion->QUESTION_TYPE_ID==2 ||$examQuestion->QUESTION_TYPE_ID==3)
            {
                $ilos[$examQuestion->id] = 0;
                $ilos_name[$examQuestion->id]=$examQuestion->ilos;
                $questions[$examQuestion->id]=$examQuestion;

            }
        }
        if(!$exam->studentExams->isEmpty())
        {
            foreach($exam->studentExams as $student)
            {
                $answers = Stud_ques_ans_choice::where('exam_id', $exam->id)->where('student_id',$student->student_id)->get();

                $answers = $answers->groupBy('question_id');

                foreach ($answers as $k => $answer) {
                    $question = $answer[0]->question;
                    if ($question->QUESTION_TYPE_ID == 1 || $question->QUESTION_TYPE_ID == 2) {
                        $choice = Question_choice::find($answer[0]->choice);
                        if ($choice->QUESTION_CHOICE_ISCORRECT) {
                            $ilos[$k]+=1;

                        }
                    }
                    if ($question->QUESTION_TYPE_ID == 3) {
                        $choicess = $question->choices;
                        if ($choicess[0]->QUESTION_CHOICE_TEXT == $answer[0]->choice) {
                            if (isset($answer[1])) {
                                $ilos[$k]+=0.5;

                            }
                            if (isset($answer[1])) {
                                if ($choicess[1]->QUESTION_CHOICE_TEXT == $answer[1]->choice) {

                                    $ilos[$k]+=0.5;
                                }

                            }

                        }
                    }


                }
            }

        }
        return view('doctor.ilos',compact('ilos','ilos_name','questions','count'));

    }

    public function createRandomQuestion($exam_id,$course_id)
    {
        $exam = Exam::find($exam_id);

        $question_list = Question::where('course_id',$course_id)->get();
        $old_questions_in_exam = QuestionExam::where('exam_id',$exam_id)->get();
        foreach($old_questions_in_exam as $one_question)
        {
            $question = QuestionExam::find($one_question->id);
            $question->delete();
        }


        // $easy_questions = Question::where([
        //                                     ['course_id',$course_id],
        //                                     ['hard','1']
        //                                   ])->get();
        // $medium_questions = Question::where([
        //                                     ['course_id',$course_id],
        //                                     ['hard','2']
        //                                   ])->get();
        // $hard_questions = Question::where([
        //                                     ['course_id',$course_id],
        //                                     ['hard','3']
        //                                   ])->get();

        // if($easy_questions->count() != 0)
        // {
        //     $easy_questions = $easy_questions->random($exam->number_easy_question);


        //     foreach($easy_questions as $one_question)
        //     {
        //         while(QuestionExam::where([
        //                                     ['exam_id',$exam_id],
        //                                     ['question_id',$one_question->id]
        //                                    ])->get()->count() == 0)
        //         {
        //             $question_exam = new QuestionExam();
        //             $question_exam->exam_id = $exam_id;
        //             $question_exam->question_id = $one_question->id;
        //             $question_exam->save();
        //         }

        //     }
        // }

        // if($medium_questions->count() != 0)
        // {
        //     $medium_questions = $medium_questions->random($exam->number_medium_question);
        //     foreach($medium_questions as $one_question)
        //     {
        //         while(QuestionExam::where([
        //                                     ['exam_id',$exam_id],
        //                                     ['question_id',$one_question->id]
        //                                    ])->get()->count() == 0)
        //         {
        //             $question_exam = new QuestionExam();
        //             $question_exam->exam_id = $exam_id;
        //             $question_exam->question_id = $one_question->id;
        //             $question_exam->save();
        //         }
        //     }
        // }
        // if($hard_questions->count() != 0)
        // {
        //     $hard_questions = $hard_questions->random($exam->number_hard_question);
        //     foreach($hard_questions as $one_question)
        //     {
        //         while(QuestionExam::where([
        //                                     ['exam_id',$exam_id],
        //                                     ['question_id',$one_question->id]
        //                                    ])->get()->count() == 0)
        //         {
        //             $question_exam = new QuestionExam();
        //             $question_exam->exam_id = $exam_id;
        //             $question_exam->question_id = $one_question->id;
        //             $question_exam->save();
        //         }
        //     }
        // }

        //-------------choose_easy_question
        $choose_easy_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','1'],
                                            ['hard','1'],
                                          ])->get();

        if($choose_easy_question->count()>= $exam->number_choose_easy_question)
        {
            $random_choose_easy_question = $choose_easy_question->random($exam->number_choose_easy_question);
            foreach($random_choose_easy_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough easy questions from choose type');
        }
        //------------------choose_meduim_question
        $choose_meduim_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','1'],
                                            ['hard','2'],
                                          ])->get();
        if($choose_meduim_question->count()>= $exam->number_choose_meduim_question)
        {
            $random_choose_meduim_question = $choose_meduim_question->random($exam->number_choose_meduim_question);
            foreach($random_choose_meduim_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough meduim questions from choose type');
        }
        //-------------choose_hard_question
        $choose_hard_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','1'],
                                            ['hard','3'],
                                          ])->get();

        if($choose_hard_question->count()>= $exam->number_choose_hard_question)
        {

            $random_choose_hard_question = $choose_hard_question->random($exam->number_choose_hard_question);
            foreach($random_choose_hard_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough hard questions from choose type');
        }

        //-------------true_and_false_easy_question
        $true_and_false_easy_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','2'],
                                            ['hard','1'],
                                          ])->get();

        if($true_and_false_easy_question->count()>= $exam->number_true_and_false_easy_question)
        {
            $random_true_and_false_easy_question = $true_and_false_easy_question->random($exam->number_true_and_false_easy_question);
            foreach($random_true_and_false_easy_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough easy questions from true and false type');
        }
        //------------------true_and_false_meduim_question
        $true_and_false_meduim_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','2'],
                                            ['hard','2'],
                                          ])->get();
        if($true_and_false_meduim_question->count()>= $exam->number_true_and_false_meduim_question)
        {
            $random_true_and_false_meduim_question = $true_and_false_meduim_question->random($exam->number_true_and_false_meduim_question);
            foreach($random_true_and_false_meduim_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough meduim questions from true and false type');
        }
        //-------------true_and_false_hard_question
        $true_and_false_hard_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','2'],
                                            ['hard','3'],
                                          ])->get();

        if($true_and_false_hard_question->count()>= $exam->number_true_and_false_hard_question)
        {

            $random_true_and_false_hard_question = $true_and_false_hard_question->random($exam->number_true_and_false_hard_question);
            foreach($random_true_and_false_hard_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough hard questions from true and false type');
        }

        //-------------complete_easy_question
        $complete_easy_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','3'],
                                            ['hard','1'],
                                          ])->get();

        if($complete_easy_question->count()>= $exam->number_complete_easy_question)
        {
            $random_complete_easy_question = $complete_easy_question->random($exam->number_complete_easy_question);
            foreach($random_complete_easy_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough easy questions from complete type');
        }
        //------------------complete_meduim_question
        $complete_meduim_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','3'],
                                            ['hard','2'],
                                          ])->get();
        if($complete_meduim_question->count()>= $exam->number_complete_meduim_question)
        {
            $random_complete_meduim_question = $complete_meduim_question->random($exam->number_complete_meduim_question);
            foreach($random_complete_meduim_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough meduim questions from complete type');
        }
        //-------------complete_hard_question
        $complete_hard_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','3'],
                                            ['hard','3'],
                                          ])->get();

        if($complete_hard_question->count()>= $exam->number_complete_hard_question)
        {

            $random_complete_hard_question = $complete_hard_question->random($exam->number_complete_hard_question);
            foreach($random_complete_hard_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough hard questions from complete type');
        }


        //-------------write_code_easy_question
        $write_code_easy_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','4'],
                                            ['hard','1'],
                                          ])->get();

        if($write_code_easy_question->count()>= $exam->number_write_code_easy_question)
        {
            $random_write_code_easy_question = $write_code_easy_question->random($exam->number_write_code_easy_question);
            foreach($random_write_code_easy_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough easy questions from write code type');
        }
        //------------------write_code_meduim_question
        $write_code_meduim_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','4'],
                                            ['hard','2'],
                                          ])->get();
        if($write_code_meduim_question->count()>= $exam->number_write_code_meduim_question)
        {
            $random_write_code_meduim_question = $write_code_meduim_question->random($exam->number_write_code_meduim_question);
            foreach($random_write_code_meduim_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough meduim questions from write code type');
        }
        //-------------write_code_hard_question
        $write_code_hard_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','4'],
                                            ['hard','3'],
                                          ])->get();

        if($write_code_hard_question->count()>= $exam->number_write_code_hard_question)
        {

            $random_write_code_hard_question = $write_code_hard_question->random($exam->number_write_code_hard_question);
            foreach($random_write_code_hard_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough hard questions from write code type');
        }


        //-------------define_easy_question
        $define_easy_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','5'],
                                            ['hard','1'],
                                          ])->get();

        if($define_easy_question->count()>= $exam->number_define_easy_question)
        {
            $random_define_easy_question = $define_easy_question->random($exam->number_define_easy_question);
            foreach($random_define_easy_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough easy questions from define type');
        }
        //------------------define_meduim_question
        $define_meduim_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','5'],
                                            ['hard','2'],
                                          ])->get();
        if($define_meduim_question->count()>= $exam->number_define_meduim_question)
        {
            $random_define_meduim_question = $define_meduim_question->random($exam->number_define_meduim_question);
            foreach($random_define_meduim_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough meduim questions from define type');
        }
        //-------------define_hard_question
        $define_hard_question = Question::where([
                                            ['course_id',$course_id],
                                            ['QUESTION_TYPE_ID','5'],
                                            ['hard','3'],
                                          ])->get();

        if($define_hard_question->count()>= $exam->number_define_hard_question)
        {

            $random_define_hard_question = $define_hard_question->random($exam->number_define_hard_question);
            foreach($random_define_hard_question as $one_question)
            {
                while(QuestionExam::where([
                                            ['exam_id',$exam_id],
                                            ['question_id',$one_question->id]
                                           ])->get()->count() == 0)
                {
                    $question_exam = new QuestionExam();
                    $question_exam->exam_id = $exam_id;
                    $question_exam->question_id = $one_question->id;
                    $question_exam->save();
                }
            }
        }
        else
        {
            dd('there is not enough hard questions from define type');
        }
        return redirect()->back();
    }


}
