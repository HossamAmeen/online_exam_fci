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
                                        <table class="table table-bordered mb-0">
                                              <thead>
                                                  <tr>
                                                      <th style="width:100px ">كود المخرج </th>
                                                      <th style="width:100px "> نص المخرج </th>
                                                      <th style="width:250px "> نسبة التحقق </th>

                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @foreach($examilos as $k=>$ilo)
                                                  <tr>
                                                      <th scope="row">{{$k+1}}</th>
                                                      <td>{{$ilo->ILO_TEXT}}</td>
                                                      <td>
                                                        <span class="text-purple float-right">{{$data[$ilo->id]['ilospercent']}}%</span>

                                                          @if($data[$ilo->id]['ilospercent']==0)

                                                          <div class="progress progress-bar-alt-purple progress-sm">
                                                              <div class="progress-bar width-0 progress-animated wow animated animated" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->
                                                          @endif
                                                          @if($data[$ilo->id]['ilospercent']>0 && $data[$ilo->id]['ilospercent']<=10)

                                                          <div class="progress progress-bar-alt-purple progress-sm">
                                                              <div class="progress-bar width-10 progress-animated wow animated animated" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->
                                                          @endif
                                                          @if($data[$ilo->id]['ilospercent']>10 && $data[$ilo->id]['ilospercent']<=20)
                                                              <div class="progress progress-bar-alt-danger progress-sm">
                                                              <div class="progress-bar width-20 progress-animated wow animated animated" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->
                                                          @endif
                                                          @if($data[$ilo->id]['ilospercent']>20 && $data[$ilo->id]['ilospercent']<=30)
                                                              <div class="progress progress-bar-alt-warning progress-sm">
                                                              <div class="progress-bar width-30 progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->
                                                      @endif
                                                          @if($data[$ilo->id]['ilospercent']>30 && $data[$ilo->id]['ilospercent']<=40)
                                                          <div class="progress progress-bar-alt-pink progress-sm">
                                                              <div class="progress-bar width-40 progress-animated wow animated animated" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->
                                                      @endif
                                                          @if($data[$ilo->id]['ilospercent']>40 && $data[$ilo->id]['ilospercent']<=50)
                                                          <div class="progress progress-bar-alt-success progress-sm">
                                                              <div class="progress-bar width-50 progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->

                                                      @endif
                                                          @if($data[$ilo->id]['ilospercent']>50 && $data[$ilo->id]['ilospercent']<=60)
                                                          <div class="progress progress-bar-alt-success progress-sm">
                                                              <div class="progress-bar width-60 progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->
                                                          @endif
                                                          @if($data[$ilo->id]['ilospercent']>60 && $data[$ilo->id]['ilospercent']<=70)
                                                          <div class="progress progress-bar-alt-success progress-sm">
                                                              <div class="progress-bar width-70 progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->

                                                      @endif
                                                          @if($data[$ilo->id]['ilospercent']>70 && $data[$ilo->id]['ilospercent']<=80)
                                                          <div class="progress progress-bar-alt-success progress-sm">
                                                              <div class="progress-bar width-80 progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->

                                                          @endif
                                                          @if($data[$ilo->id]['ilospercent']>80 && $data[$ilo->id]['ilospercent']<=90)
                                                          <div class="progress progress-bar-alt-success progress-sm">
                                                              <div class="progress-bar width-90 progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->
                                                          @endif

                                                          @if($data[$ilo->id]['ilospercent']>90 && $data[$ilo->id]['ilospercent']<=100)
                                                          <div class="progress progress-bar-alt-success progress-sm">
                                                              <div class="progress-bar width-100 progress-animated wow animated animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                                          </div><!-- /.progress .no-rounded -->
                                                          @endif
                                                      </td>

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
