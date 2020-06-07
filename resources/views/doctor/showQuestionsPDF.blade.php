<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title></title>
    <style>
    body { font-family: DejaVu Sans, sans-serif;}
    table.t2 {
      border-left: 0.01em solid #ccc;
      border-right: 0;
      border-top: 0.01em solid #ccc;
      border-bottom: 0;
      border-collapse: collapse;
    }
    table td.ct2,
    table th.ct2 {
      border-left: 0;
      border-right: 0.01em solid #ccc;
      border-top: 0;
      border-bottom: 0.01em solid #ccc;
    }
    table td{
      padding-left: 10px;
    }
    </style>
  </head>
  <body>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                  <hr>
                    <div class="row ">

                      <table class="table table-responsive" style="width:100%;">
                        <tr>
                          <td >
                            <b>Student Name:</b>
                          </td>
                          <td style="text-align:center;">
                            <span>{{$student->STUDENT_NAME}}</span>
                          </td>
                          <td >
                            <b>Student SSN:</b>
                          </td>
                          <td style="text-align:center;">
                            <span> {{$student->STUDENT_SSN}} </span>
                          </td>
                        </tr>
                        <tr>
                          <td >
                            <b>Faculty:</b>
                          </td>
                          <td style="text-align:center;">
                            <span>{{$exam->course->department->faculity->FACULTY_NAME}}</span>
                          </td>
                          <td >
                            <b>Department:</b>
                          </td>
                          <td style="text-align:center;">
                            <span> {{$exam->course->department->DEPARTMENT_NAME}} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <b>Stage \ Level:</b>
                          </td>
                          <td style="text-align:center;">
                            <span> {{$exam->course->COURSES_LEVEL}} </span>
                          </td>
                          <td >
                            <b>Course:</b>
                          </td>
                          <td style="text-align:center;">
                            <span> {{$exam->course->COURSE_NAME}} </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <b>Exam:</b>
                          </td>
                          <td style="text-align:center;">
                            <span> <span>{{$exam->EXAM_NAME}} </span>
                          </td>
                          <td>
                            <b>Date:</b>
                          </td>
                          <td style="text-align:center;">
                            <span> {{$exam->date}} </span>
                          </td>
                        </tr>
                      </table>
                        <!-- <div class="col-md-12">
                            <div class="col-md-4 ">
                                <p> القسم : <span> {{$exam->course->department->DEPARTMENT_NAME}} </span></p>
                                <p> المستوى / الفرقة : <span> {{$exam->course->COURSES_LEVEL}} </span></p>
                                <p> التاريخ : <span> {{$exam->date}} </span></p>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-6 text-right">
                                <p> الكلية : <span>{{$exam->course->department->faculity->FACULTY_NAME}} </span></p>
                                <p> المادة : <span> {{$exam->course->COURSE_NAME}} </span></p>
                                <p> اسم الإمتحان : <span>{{$exam->EXAM_NAME}} </span></p>
                            </div>
                        </div> -->
                    </div>
                    <hr>
                    <div class="row">
                        <table class="table table-bordered table-responsive t2">
                            <tr>
                                <th class="ct2">Question</th>
                                <th class="ct2">Answer</th>
                                <th class="ct2">Score</th>
                            </tr>
                                {!!  csrf_field() !!}
                            @foreach($stud_ques_ans_choices as $st)
                                <tr>
                                    <td class="ct2">
                                        {!!$st->question->QUESTION_TEXT!!}
                                    </td>
                                    <td class="ct2">
                                        @if(is_numeric($st->choice)  )
                                            {{$st->choices->QUESTION_CHOICE_TEXT}}
                                        @else
                                            {{$st->choice}}
                                        @endif

                                    </td>
                                    <td class="ct2" style=" text-align:center;">
                                            {{$st->point}} / {{$st->question->POINTS}}
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="row">


        <!-- end col-->
    </div>
</body>
</html>
