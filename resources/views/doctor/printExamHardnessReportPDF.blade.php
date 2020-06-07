<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- App title -->
    <title> online Exam Systeme</title>
    <!-- form Uploads -->
    <link href="{{asset('assets/plugins/fileuploads/css/dropify.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Plugins css-->
    <link href="{{asset('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/multiselect/css/multi-select.css')}}"  rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/select2/dist/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">


    <!-- Editatable  Css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/magnific-popup/dist/magnific-popup.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-editable/datatables.css')}}" />

    <!-- App CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/menu.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{asset('assets/js/modernizr.min.js')}}"></script>

</head>
<body>
<div class="row" style="direction:rtl;">
                      <div class="col-md-12">
                          <div class="panel panel-default">
                              <!-- <div class="panel-heading">
                                      <h4>Invoice</h4>
                                  </div> -->
                              <div class="panel-header dispaly-non">
                                  <div class="row right-dir">
                                      <div class="col-md-4 ">

                                          <img class="img-responsive logo-img" src="{{asset('assets/images/ic.jpg')}}">

                                      </div>
                                      <div class="col-md-2">
                                      </div>
                                      <div class="col-md-6">

                                          <img class="img-responsive logo-img" src="{{asset('assets/images/logo.png')}}">


                                      </div>
                                  </div>
                              </div>
                              <div class="panel-body">
                                  <div class="m-h-10"></div>
                                  <div class="row right-dir mb-40">

                                      <div class="col-md-12">
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
                                      </div>
                                  </div>
                                  <hr>
                                  <div class="col-md-12">
                                      <div class="question-number text-center mb-40 ">
                                          <!--                                                <p>ilos achievement  report</p>-->
                                          <h3 class="bold"> تقرير معاملات السهول والصعوبة والتميز</h3>
                                      </div>

                                  </div>
                                  <div class="col-md-12 right-dir">

                                      <div class="table-responsive  mb-40">
                                          <table class="table table-bordered mb-0" >
                                              <thead>
                                                  <tr>
                                                      <th style="width:100px;text-align:center;">الرقم </th>
                                                      <th style="width:100px;text-align:center; ">نوع السؤال </th>
                                                      <th style="width:250px;text-align:center; ">نص السؤال </th>
                                                      <th style="width:200px;text-align:center; ">معامل السهولة والصعوبة </th>
                                                      <th style="width:150px;text-align:center; ">معامل التمييز </th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($questions as $k=>$question)
                                                  <tr>
                                                      <th scope="row" style="text-align:center;">{{$k+1}}</th>
                                                      <td style="text-align:right;">{{$question->questiontype->QUESTION_TYPE_DESCR}}</td>
                                                      <td style="text-align:right;">{!!$question->QUESTION_TEXT!!}</td>
                                                      <td style="text-align:center;">{{$data[$question->id]['hardness']}}</td>
                                                      <td style="text-align:center;">{{$data[$question->id]['diff']}} </td>
                                                  </tr>
                                                  @endforeach
                                              </tbody>
                                          </table>
                                      </div>



                                  </div>

            
                              </div>
                          </div>
                      </div>
                  </div>
</body>
</html>
