@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading">
                        <h4>Invoice</h4>
                    </div> -->
            <div class="panel-header exam-row-two">

                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="faculty-name m-t-5"> {{$exam->course->department->faculity->FACULTY_NAME}}

                        </h4>
                      </h4>
                      @if($exam->type==1)
                      <p class="m-t-5"> Quiz</p>
                      @endif
                      @if($exam->type==2)
                      <p class="m-t-5"> Midterm</p>
                      @endif
                      @if($exam->type==3)
                      <p class="m-t-5"> Final</p>
                      @endif
                      @if($exam->type==4)
                      <p class="m-t-5"> Report</p>
                      @endif
                      <span class=""><strong>Date: </strong> {{$exam->date}}</span>
                        <span class="m-l-15"><strong>Time: </strong> <span class="label label-pink">

                                <?php
                                    $hours = floor($exam->EXAM_DURATION / 60);
                                    $minutes = ($exam->EXAM_DURATION % 60);

                                    echo sprintf('%02d:%02d:00', $hours, $minutes);

                                    ?>

                            </span></span>

                    </div>

                    <div class="pull-right m-t-10">

                        <img class="img-responsive logo-img" src="{{asset('assets/images/logo.png')}}">
                    </div>
                </div>

            </div>
            <div id="formclick" class="panel-body">
                <div class="m-h-10"></div>
                <form action="{{route('student.exam.answer',$exam->id)}}" id="form" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <?php
                                $i=1;
                            ?>
                            @if($exam->type==4)
                            <div class="col-md-12 question">
                                <div class="question-number">

                                    <p>Report <span>[100] </span> :</p>
                                </div>
                                <div>
                                    <p class="question-title m-t-20">
                                        <span>Please, upload your academic essay as single word or PDF file.</span>
                                    </p>
                                        <div class="col-md-11" style="margin-bottom: 30px">
                                            <div class="dropdown pull-right">
                                            </div>

                                            <input type="file" name="import_file" class="dropify" data-max-file-size="10M"/>
                                        </div>
                                  </div>
                                </div>
                            @endif
                        @foreach($questions as $k=>$question)

                        @if($k==1)
                        <div class="col-md-12 question">
                            <div class="question-number">
                                <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> </span> choose
                                </p>

                                @foreach($question as $j=>$q)
                                <div class="row question-body m-t-20">
                                    <div class="col-md-12">
                                        <span> {{$j+1}}:{!!$q->QUESTION_TEXT!!}</span>
                                    </div>
                                    @if(isset($q->image))
                                    <div class="col-md-12">
                                        <img src="{{asset($q->image->path)}}" style="width:100%;height:auto;">
                                    </div>
                                    @endif
                                    @foreach($q->choices as $kk=>$choice)
                                    <div class="col-md-3">


                                        <div class="radio radio-custom ">
                                            <input type="radio" name="choice_{{$q->id}}[]" id="radio03"
                                                value="{{$choice->id}}">
                                            <label for="radio03">
                                                {{$choice->QUESTION_CHOICE_TEXT}}
                                            </label>
                                        </div>
                                        @if(isset($choice->image))
                                        <div class="radio radio-custom ">
                                            <img src="{{asset($choice->image->path)}}" style="width:100%;height:auto;">
                                        </div>
                                        @endif

                                    </div>
                                    @endforeach
                                </div>
                                @endforeach

                            </div>
                        </div>

                        @endif

                        @if($k==2)
                        <div class="col-md-12 question">
                            <div class="question-number">
                                <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> A .</span> True or False
                                </p>
                                @foreach($question as $j=>$q)

                                <div class="row question-body m-t-20">
                                    <div class="col-md-12">
                                        {{$j+1}}:{!!$q->QUESTION_TEXT!!}


                                    </div>
									 @if(isset($q->image))
                                    <div class="col-md-12">
                                        <img src="{{asset($q->image->path)}}" style="width:100%;height:auto;">
                                    </div>
                                    @endif

                                    @foreach($q->choices as $kk=>$choice)
                                    <div class="col-md-3">


                                        <div class="radio radio-custom ">
                                            <input type="radio" name="choice_{{$q->id}}[]" id="radio03"
                                                value="{{$choice->id}}">
                                            <label for="radio03">
                                                {{$choice->QUESTION_CHOICE_TEXT}}
                                            </label>
                                        </div>


                                    </div>
                                    @endforeach


                                </div>
                                @endforeach


                            </div>
                        </div>
                        @endif
                        @if($k==3)
                        <div class="col-md-12 question">
                            <div class="question-number">
                                <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> A .</span> Complete
                                </p>
                                @foreach($question as $j=>$q)

                                <div class="row question-body m-t-20">
                                    <div class="col-md-12">
                                        {{$j+1}}:{!!$q->QUESTION_TEXT!!}

                                    </div>

									 @if(isset($q->image))
                                    <div class="col-md-12">
                                        <img src="{{asset($q->image->path)}}" style="width:100%;height:auto;">
                                    </div>
                                    @endif
                                    @foreach($q->choices as $kk=>$choice)
                                    <div class="col-md-3">

                                        <div class="radio radio-custom ">
                                            @if($choice->QUESTION_CHOICE_TEXT)

                                            <input type="text" name="choice_{{$q->id}}[]" id="radio03" value=" ">
                                            {{--<label for="radio03">--}}

                                            {{--</label>--}}
                                            @endif
                                        </div>


                                    </div>
                                    @endforeach


                                </div>

                                @endforeach
                            </div>
                        </div>

                        @endif
                        @if($k==4)
                        <div class="col-md-12 question">
                            <div class="question-number">
                                <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> A .</span> Code
                                </p>
                                <div class="question-body m-t-20">


                                    @foreach($question as $j=>$q)


                                    <div class="form-group">
                                        <label class="control-label">{{$j+1}}:{!!$q->QUESTION_TEXT!!}</label>
                                         @if(isset($q->image))
                                    <div class="col-md-12">
                                        <img src="{{asset($q->image->path)}}" style="width:100%;height:auto;">
                                    </div>
                                    @endif
										<div class="">
                                            <textarea required="" name="choice_{{$q->id}}[]" class="form-control"
                                                data-parsley-id="50">

                                                    </textarea>
                                        </div>
                                    </div>
                                    @endforeach
                                    {{--                                            {{dd($q,$Stud_ques_ans_choice)}}--}}



                                </div>

                            </div>
                        </div>
                        @endif
                        @if($k==5)
                        <div class="col-md-12 question">
                            <div class="question-number">
                                <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> A .</span> Define
                                </p>
                                <div class="question-body m-t-20">


                                    @foreach($question as $j=>$q)


                                    <div class="form-group">
                                        <label class="control-label">{{$j+1}}:{!!$q->QUESTION_TEXT!!}</label>
                                         @if(isset($q->image))
                                    <div class="col-md-12">
                                        <img src="{{asset($q->image->path)}}" style="width:100%;height:auto;">
                                    </div>
                                    @endif
										<div class="">
                                            <textarea onfocusout="saveAnswer()" required="" name="choice_{{$q->id}}[]"
                                                class="form-control" data-parsley-id="50">


                                                    </textarea>
                                        </div>
                                    </div>
                                    @endforeach



                                </div>

                            </div>
                        </div>
                        @endif



                        <?php $i++;
                                ?>
                        @endforeach

                    </div>
                    <div class="row">

                        <div class="col-md-12 text-center">

                            <h4>Best Wishes</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="hidden-print">
                        <div class="pull-right">
                          <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                            <a href="{{route('doctorProfile.index')}}"
                                class="btn btn-inverse waves-effect waves-light">Back</a>

                            {{--<button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>--}}
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
@section('script')
{{--<script language="Javascript">--}}
{{--var timer = 0;--}}
{{--var timer2 = 0;--}}
{{--var stop = 0;--}}
{{--$(document).ready(function (e) {--}}


{{--var $worked = $("#minutes");--}}

{{--function update() {--}}
{{--var myTime = $worked.html();--}}
{{--var ss = myTime.split(":");--}}
{{--console.log(ss);--}}
{{--//  alert(ss[0]);--}}
{{--var dt = new Date();--}}
{{--dt.setHours(ss[0]);--}}
{{--dt.setMinutes(ss[1]);--}}
{{--dt.setSeconds(ss[2]);--}}

{{--var dt2 = new Date(dt.valueOf() - 1000);--}}
{{--var temp = dt2.toTimeString().split(" ");--}}
{{--var ts = temp[0].split(":");--}}
{{--$worked.html(ts[0] + ":" + ts[1] + ":" + ts[2]);--}}
{{--//--}}
{{--$.ajax({--}}
{{--type: "POST",--}}
{{--url: '{{route('student.time.save')}}',--}}
{{--data: {time : (ts[0] + ":" + ts[1] + ":" + ts[2]),exam_id:"{{$exam->id}}",_token:"{!! csrf_token()
!!}",enddate:"{{$endTime}}"},--}}
{{--dataType: 'JSON',--}}
{{--success: function (data) {--}}
{{--},--}}
{{--error: function (XMLHttpRequest, textStatus, errorThrown) {--}}
{{--}--}}
{{--});--}}
{{--$.ajax({--}}
{{--type: "GET",--}}
{{--url: '{{route('student.time')}}',--}}
{{--dataType: 'JSON',--}}
{{--success: function (data) {--}}
{{--if (data == "{{$endTime}}") {--}}

{{--$.ajax({--}}
{{--type: "POST",--}}
{{--url: "{{route('student.exam.answer',$exam->id)}}",--}}
{{--data: $('#form').serialize(), // serializes the form's elements.--}}
{{--success: function(data)--}}
{{--{--}}
{{--//alert(data); // show response from the php script.--}}
{{--}--}}
{{--});--}}
{{--alert('TIME IS OUT THANK YOU')--}}

{{--window.location = "{{route('student.exam.result', $exam->id)}}";--}}
{{--}--}}

{{--},--}}
{{--error: function (XMLHttpRequest, textStatus, errorThrown) {--}}
{{--}--}}

{{--});--}}

{{--timer = setTimeout(update, 1000);--}}

{{--return stop;--}}

{{--function stop() {--}}
{{--if (timer) {--}}
{{--clearTimeout(timer);--}}
{{--timer = 0;--}}
{{--}--}}
{{--}--}}
{{--}--}}

{{--function update2() {--}}
{{--var myTime = $worked.html();--}}
{{--var ss = myTime.split(":");--}}

{{--if (ss[0] == 00 && ss[1] == 00 && ss[2] == 00) {--}}
{{--stop();--}}
{{--$.ajax({--}}
{{--type: "GET",--}}
{{--url: '{{route('student.time')}}',--}}
{{--dataType: 'JSON',--}}
{{--success: function (data) {--}}
{{--if (data == "{{$endTime}}") {--}}

{{--$.ajax({--}}
{{--type: "POST",--}}
{{--url: "{{route('student.exam.answer',$exam->id)}}",--}}
{{--data: $('#form').serialize(), // serializes the form's elements.--}}
{{--success: function(data)--}}
{{--{--}}
{{--//alert(data); // show response from the php script.--}}
{{--}--}}
{{--});--}}
{{--alert('TIME IS OUT THANK YOU')--}}

{{--window.location = "{{route('student.exam.result', $exam->id)}}";--}}
{{--//                            }--}}

{{--},--}}
{{--error: function (XMLHttpRequest, textStatus, errorThrown) {--}}
{{--}--}}

{{--});--}}
{{--}--}}
{{--timer2 = setTimeout(update2, 1000);--}}

{{--}--}}

{{--stop = update();--}}
{{--var stop2 = setTimeout(update2, 1000);--}}
{{--//            stop();--}}

{{--});--}}
{{--function saveAnswer(){--}}
{{--$.ajax({--}}
{{--type: "POST",--}}
{{--//                async: false,--}}
{{--//                cache: false,--}}
{{--url: "{{route('student.exam.answerAjax',$exam->id)}}",--}}
{{--data: $('#form').serialize(), // serializes the form's elements.--}}
{{--success: function(data)--}}
{{--{--}}
{{--//alert(data); // show response from the php script.--}}
{{--},--}}
{{--error: function(XMLHttpRequest, textStatus, errorThrown) {--}}
{{--alert("Faild to save Your Answer! please click any where in document");--}}
{{--}--}}

{{--});--}}
{{--}--}}
{{--$('#formclick').on('click', function (event) {--}}
{{--if (event.target != this) {--}}
{{--$.ajax({--}}
{{--type: "POST",--}}
{{--async: false,--}}
{{--cache: false,--}}
{{--url: "{{route('student.exam.answerAjax',$exam->id)}}",--}}
{{--data: $('#form').serialize(), // serializes the form's elements.--}}
{{--success: function(data)--}}
{{--{--}}
{{--//alert(data); // show response from the php script.--}}
{{--},--}}
{{--error: function(XMLHttpRequest, textStatus, errorThrown) {--}}
{{--alert("Faild to save Your Answer! please click any where in document");--}}
{{--}--}}

{{--});--}}
{{--// alert('You clicked a descendent of #container.');--}}
{{--} else {--}}
{{--//alert('You actually clicked #container itself.');--}}
{{--}--}}
{{--});--}}
{{--</script>--}}
@endsection
