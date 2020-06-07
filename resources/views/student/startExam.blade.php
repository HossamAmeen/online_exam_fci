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
                    <div class="col-sm-3">
                        <h4 class="faculty-name m-t-5"> {{$exam->course->department->faculity->FACULTY_NAME}}

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
                        <span class="m-l-15"><strong>Left: </strong> <span id="minutes" class="label label-pink">

                                <?php

                                  //  $time=App\Time::where('user_id',auth()->user()->id)->where('exam_id',$exam->id)->first();


                                   date_default_timezone_set('Africa/Cairo');
                                    /*
                                                                        $datetime1 = new DateTime($endTime);
                                                                        $datetime2 = new DateTime(date("G:i:s", time()));
                                                                        $interval = $datetime1->diff($datetime2);

                                                                        echo $interval->format('%h') . ":" . $interval->format('%i') . ":" . $interval->format('%s');
                                                                        */
                                    if($time)
                                    {

                                        $datetime1 = new DateTime($time->enddate);
                                        $datetime2 = new DateTime(date("G:i:s"));
                                        $interval = $datetime1->diff($datetime2);

                                        $interval= $interval->format('%h') . ":" . $interval->format('%i') . ":" . $interval->format('%s');
//                                        dd($time->time,$interval);
                                     //   if($time->time<=$interval){
                                            echo   $interval;

//                                        }else
//                                            {
//                                                echo $time->time;
//
//                                            }

                                    }else{
                                        $hours = floor($exam->EXAM_DURATION / 60);
                                        $minutes = ($exam->EXAM_DURATION % 60);

                                        echo sprintf('%02d:%02d:00', $hours, $minutes);
                                          }
                                    ?>

                            </span></span>

                    </div>
                    <div class="col-sm-6">
                        <div id="vid-controls">
                          <video id="vid-show" style="width:100%;height:150px;" autoplay>{!! csrf_field() !!}</video>
                          <!-- <input id="vid-take" type="button" value="Take Photo"/> -->
                          <div id="vid-canvas">{!! csrf_field() !!}</div>
                        </div>
                    </div>
                    <div class="col-sm-2">

                        <img class="img-responsive logo-img" src="{{asset('assets/images/logo.png')}}">
                    </div>
                </div>

            </div>
            <div id="formclick" class="panel-body">
                <div class="m-h-10"></div>
                <form action="{{route('student.exam.answer',$exam->id)}}" id="form" method="post">
                    {!! csrf_field() !!}
                    <div class="row">

                        <?php $i=1; $sum_point = 0 ?>
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
                                {{-- <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p> --}}
                                <p>Question {{$i}} <span>[{{ $sum_array[$k] }}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> </span> choose
                                </p>

                                @foreach($question as $j=>$q)
                                <div class="row question-body m-t-20">
                                    <div class="col-md-12">
                                        <span> {{$j+1}}: <br>
                                            {!! ($q->QUESTION_TEXT) !!}
                                        </span>
                                    </div>
									@if(isset($q->image))
                                    <div class="col-md-12">
                                        <img style="width:100%;height:auto;" src="{{asset($q->image->path)}}">
                                    </div>
                                    @endif
                                    @foreach($q->choices as $kk=>$choice)
                                    <div class="col-md-3 ">
                                        <?php

                                                            $Stud_ques_ans_choice=App\Stud_ques_ans_choice::where('exam_id', $exam->id)->where('choice', $choice->id)->where('student_id',auth()->user()->student->id)->get()->first();

                                                            ?>

                                        <div class="">
                                            <input style="float: left" type="radio" onclick="saveAnswer()"
                                                @if($Stud_ques_ans_choice) checked @endif name="choice_{{$q->id}}[]"
                                                id="radio03" value="{{$choice->id}}">
                                            <label style="margin-top: 12px;margin-left: 5px">
                                                {{$choice->QUESTION_CHOICE_TEXT}}
                                            </label>
                                        </div>
										 @if(isset($choice->image))
                                        <div class="radio radio-custom ">
                                            <img src="{{asset($choice->image->path)}}" style="width:100%;height:auto;" >
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
                                {{-- <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p> --}}
                                <p>Question {{$i}} <span>[{{ $sum_array[$k] }}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> A .</span> True or False
                                </p>
                                @foreach($question as $j=>$q)

                                <div class="row question-body m-t-20">
                                    <div class="col-md-12">
                                        {{$j+1}}: <br>{!! $q->QUESTION_TEXT !!}


                                    </div>

									@if(isset($q->image))
                                    <div class="col-md-12">
                                        <img src="{{asset($q->image->path)}}" style="width:100%;height:auto;">
                                    </div>
                                    @endif
                                    @foreach($q->choices as $kk=>$choice)
                                    <div class="col-md-3">

                                        <?php
                                                    $Stud_ques_ans_choice=App\Stud_ques_ans_choice::where('exam_id', $exam->id)->where('choice', $choice->id)->where('student_id',auth()->user()->student->id)->get()->first();

                                                            ?>
                                        <div class="">
                                            <input style="float: left" type="radio" onclick="saveAnswer()"
                                                @if($Stud_ques_ans_choice) checked @endif name="choice_{{$q->id}}[]"
                                                id="radio03" value="{{$choice->id}}">
                                            <label style="margin-top: 12px;margin-left: 5px">
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
                                {{-- <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p> --}}
                                <p>Question {{$i}} <span>[{{ $sum_array[$k] }}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> A .</span> Complete
                                </p>
                                @foreach($question as $j=>$q)

                                <div class="row question-body m-t-20">
                                    <div class="col-md-12">
                                        {{$j+1}}:<br>{!! $q->QUESTION_TEXT !!}

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
                                            <?php
                                                            $Stud_ques_ans_choice=App\Stud_ques_ans_choice::where('exam_id', $exam->id)->where('question_id', $q->id)->where('student_id',auth()->user()->student->id)->get();

                                                            ?>
                                            <input type="text" onfocusout="saveAnswer()" name="choice_{{$q->id}}[]"
                                                id="radio03" value="<?php
                                                                if(!$Stud_ques_ans_choice->isEmpty())
                                                                    {
                                                        if($Stud_ques_ans_choice[0] && $kk==0)
                                                            {
                                                          echo      $Stud_ques_ans_choice[0]->choice;
                                                            }else{
                                                            if(isset($Stud_ques_ans_choice[1]))
                                                                echo  $Stud_ques_ans_choice[1]->choice;

                                                        }
                                                        }
?>
                                                        {{--{{}}--}}


                                                        ">
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
                                {{-- <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p> --}}
                                <p>Question {{$i}} <span>[{{ $sum_array[$k] }}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> A .</span> Code
                                </p>
                                <div class="question-body m-t-20">


                                    @foreach($question as $j=>$q)

                                    <?php
                                                $Stud_ques_ans_choice=App\Stud_ques_ans_choice::where('exam_id', $exam->id)->where('question_id', $q->id)->where('student_id',auth()->user()->student->id)->get()->first();
                                                ?>
                                    <div class="form-group">
                                        <label class="control-label">{{$j+1}}:<br>{!! $q->QUESTION_TEXT !!}</label>
                                        @if(isset($q->image))
                                    <div class="col-md-12">
                                        <img src="{{asset($q->image->path)}}" style="width:100%;height:auto;">
                                    </div>
                                    @endif
										<div class="">
                                            <textarea onfocusout="saveAnswer()" required="" name="choice_{{$q->id}}[]"
                                                class="form-control" data-parsley-id="50">
                                                        @if($Stud_ques_ans_choice)
                                                        {{$Stud_ques_ans_choice->choice}}
                                                            @endif
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
                                {{-- <p>Question {{$i}} <span>[{{$question->sum('POINTS')}}] </span> :</p> --}}
                                <p>Question {{$i}} <span>[{{ $sum_array[$k] }}] </span> :</p>
                            </div>
                            <div>
                                <p class="question-title m-t-20">
                                    <span> A .</span> Define
                                </p>
                                <div class="question-body m-t-20">


                                    @foreach($question as $j=>$q)

                                    <?php
                                                    $Stud_ques_ans_choice=App\Stud_ques_ans_choice::where('exam_id', $exam->id)->where('question_id', $q->id)->where('student_id',auth()->user()->student->id)->get()->first();
                                                    ?>
                                    <div class="form-group">
                                        <label class="control-label">{{$j+1}}:<br>{!! $q->QUESTION_TEXT !!}</label>
                                        @if(isset($q->image))
                                    <div class="col-md-12">
                                        <img src="{{asset($q->image->path)}}" style="width:100%;height:auto;">
                                    </div>
                                    @endif
										<div class="">
                                            <textarea onfocusout="saveAnswer()" required="" name="choice_{{$q->id}}[]"
                                                class="form-control" data-parsley-id="50">
                                                                                                                @if($Stud_ques_ans_choice)

                                                        {{$Stud_ques_ans_choice->choice}}
                                                                                                                    @endif

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
                            {{--<a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i--}}
                            {{--class="fa fa-print"></i></a>--}}
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
@section('script')
@if($exam->camera_required==1)
<script language="Javascript">
window.addEventListener("load", function(){
  // [1] GET ALL THE HTML ELEMENTS
  var video = document.getElementById("vid-show"),
      canvas = document.getElementById("vid-canvas"),
      take = document.getElementById("vid-take");

  // [2] ASK FOR USER PERMISSION TO ACCESS CAMERA
  // WILL FAIL IF NO CAMERA IS ATTACHED TO COMPUTER
  navigator.mediaDevices.getUserMedia({ video : true })
  .then(function(stream) {
    // [3] SHOW VIDEO STREAM ON VIDEO TAG
    video.srcObject = stream;
    video.play();

    function uploadImage(){var draw = document.createElement("canvas");
    draw.width = video.videoWidth;
    draw.height = video.videoHeight;
    var context2D = draw.getContext("2d");
    context2D.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
    // Upload to server
    draw.toBlob(function(blob){
      var data = new FormData();
      data.append('_token', '{{ csrf_token() }}')
      data.append('upimage', blob);

      //alert('test');
      var xhr = new XMLHttpRequest();

      xhr.open('POST', "{{route('student.exam.camimage',$exam->id)}}", true);

      xhr.onload = function(){
        if (xhr.status==403 || xhr.status==404) {
          alert("ERROR LOADING 3-UPLOAD.PHP");
        } else {

          //alert(this.response);
        }
      };
      //alert('test2');

      xhr.send(data);
      //alert('test3');

    });
    setTimeout(uploadImage,3000);
    };
    // [4] WHEN WE CLICK ON "TAKE PHOTO" BUTTON
    setTimeout(uploadImage,3000);
    // take.addEventListener("click", function(){
    //   // Create snapshot from video
    //   var draw = document.createElement("canvas");
    //   draw.width = video.videoWidth;
    //   draw.height = video.videoHeight;
    //   var context2D = draw.getContext("2d");
    //   context2D.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
    //   // Upload to server
    //   draw.toBlob(function(blob){
    //     var data = new FormData();
    //     data.append('_token', '{{ csrf_token() }}')
    //     data.append('upimage', blob);
    //
    //     alert('test');
    //     var xhr = new XMLHttpRequest();
    //
    //     xhr.open('POST', "{{route('student.exam.camimage',$exam->id)}}", true);
    //
    //     xhr.onload = function(){
    //       if (xhr.status==403 || xhr.status==404) {
    //         alert("ERROR LOADING 3-UPLOAD.PHP");
    //       } else {
    //
    //         alert(this.response);
    //       }
    //     };
    //     alert('test2');
    //
    //     xhr.send(data);
    //     alert('test3');
    //
    //   });
    // });
  })
  .catch(function(err) {
    document.getElementById("vid-controls").innerHTML = "Please enable access and attach a camera";
    alert('You can not begin the exam without the camera. Please, be sure that your camera is on and you give the permission to the browser for using your camera.');
    window.location = "{{route('student.index')}}";
  });
});
</script>
@endif
<script language="Javascript">

    var timer = 0;
        var timer2 = 0;
        var stop = 0;
        $(document).ready(function (e) {


            var $worked = $("#minutes");

            function update() {
                var myTime = $worked.html();
                var ss = myTime.split(":");
                console.log(ss);
                //  alert(ss[0]);
                var dt = new Date();
                dt.setHours(ss[0]);
                dt.setMinutes(ss[1]);
                dt.setSeconds(ss[2]);

                var dt2 = new Date(dt.valueOf() - 1000);
                var temp = dt2.toTimeString().split(" ");
                var ts = temp[0].split(":");
                $worked.html(ts[0] + ":" + ts[1] + ":" + ts[2]);
                //
                {{--$.ajax({--}}
                    {{--type: "POST",--}}
                    {{--url: '{{route('student.time.save')}}',--}}
                    {{--data: {time : (ts[0] + ":" + ts[1] + ":" + ts[2]),exam_id:"{{$exam->id}}",_token:"{!! csrf_token() !!}",enddate:"{{$endTime}}"},--}}
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

                    timer = setTimeout(update, 1000);

                return stop;

                function stop() {
                    if (timer) {
                        clearTimeout(timer);
                        timer = 0;
                    }
                }
            }

            function update2() {
                var myTime = $worked.html();
                var ss = myTime.split(":");

                if (ss[0] == 00 && ss[1] == 00 && ss[2] == 00) {
                    stop();
                    $.ajax({
                        type: "GET",
                        url: '{{route('student.time')}}',
                        dataType: 'JSON',
                        success: function (data) {
                            {{--if (data == "{{$endTime}}") {--}}

                                $.ajax({
                                    type: "POST",
                                    url: "{{route('student.exam.answer',$exam->id)}}",
                                    data: $('#form').serialize(), // serializes the form's elements.
                                    success: function(data)
                                    {
                                        //alert(data); // show response from the php script.
                                    }
                                });
                                alert('TIME IS OUT THANK YOU')

                                window.location = "{{route('student.exam.result', $exam->id)}}";
//                            }

                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                        }

                    });
                }
                timer2 = setTimeout(update2, 1000);

            }

            stop = update();
            var stop2 = setTimeout(update2, 1000);
//            stop();

        });
        function saveAnswer(){
            $.ajax({
                type: "POST",
                async: false,
                cache: false,
                url: "{{route('student.exam.answerAjax',$exam->id)}}",
                data: $('#form').serialize(), // serializes the form's elements.
                success: function(data)
                {
                    //alert(data); // show response from the php script.
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                   /// alert("Faild to save Your Answer! please click any where in document");
                }

            });
        }
        $('#formclick').on('click', function (event) {
            if (event.target != this) {
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
               // alert('You clicked a descendent of #container.');
            } else {
                //alert('You actually clicked #container itself.');
            }
        });
</script>
<script>
    history.pushState(null, null,null);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, null);
        });
</script>
@endsection
