@extends('layouts.app')

@section('content')
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

                                  <div class="hidden-print">
                                      <div class="pull-right">
                                          <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>

                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
@endsection
