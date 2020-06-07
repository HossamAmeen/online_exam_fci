@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <h3 style="text-align:center">Student Name:{{$student->STUDENT_NAME}}</h3>
                        <form action="{{route('doctorProfile.post.question')}}" method="post">

                        <table class="table table-bordered table-responsive">
                            <tr>
                                <th>Question</th>
                                <th>answer</th>
                                <th>Full Grade</th>
                                <th>Student Grade</th>
                            </tr>
                                {!!  csrf_field() !!}
                            @foreach($stud_ques_ans_choices as $st)
                                <tr>
                                    <td>
                                        {!!$st->question->QUESTION_TEXT!!}
                                    </td>
                                    <td>
                                        @if(is_numeric($st->choice)  )
                                            {{$st->choices->QUESTION_CHOICE_TEXT}}
                                        @else
                                            {{$st->choice}}
                                        @endif

                                    </td>
                                    <td>
                                        {{$st->question->POINTS}}
                                    </td>
                                    <td>
                                        @if($st->question->QUESTION_TYPE_ID ==1 ||$st->question->QUESTION_TYPE_ID==2 ||$st->question->QUESTION_TYPE_ID==3 )
{{--                                            {{$st->choices->QUESTION_CHOICE_TEXT}}--}}
                                            {{$st->point}}
                                        @else( $st->question->QUESTION_TYPE_ID ==4 || $st->question->QUESTION_TYPE_ID ==5)
                                            <input type="hidden" name="stud_ques[]" value="{{$st->id}}">
                                            <input type="text" name="grades[]" value="{{$st->point}}">

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><input type="submit" class="btn btn-primary"></td>

                                </tr>

                        </table>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="row">


        <!-- end col-->
    </div>
@endsection
@section('script')

@endsection
