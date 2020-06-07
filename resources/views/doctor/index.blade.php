@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

                <div class="col-md-4">
                    <div class="text-center card-box">

                        <div>
                            <img src="{{asset('assets/images/users/avatar-10.jpg')}}" class="img-circle thumb-xl img-thumbnail m-b-30" alt="profile-image">



                            <form action="#" class="form-horizontal editor-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Name</label>
                                    <div class="col-sm-7 text-left">
                                        <a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username">{{auth()->user()->name}}</a>
                                    </div>
                                </div>
                                <div class="form-group text-left">
                                    <label class="col-sm-5 control-label">Phone</label>
                                    <div class="col-sm-7">
                                        <a href="#" id="phone" data-type="text" data-pk="1" data-title="Enter phone">{{auth()->user()->staff->phone}}</a>
                                    </div>
                                </div>




                            </form>

                        </div>

                    </div>

                </div>
                <div class="col-md-8">
                    <div class="row">


                        <div class="panel">
                            <div class="col-sm-12 m-t-30 m-b-50  ">

                                <a href="{{route('doctorProfile.exam.creates')}}" class="btn btn-success btn-rounded w-md waves-effect waves-light">Create Exam</a>

                            </div>

                            <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Last Exams</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default bx-shadow-none">
                                                            <div class="panel-heading" role="tab" id="headingOne">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                        Quizzes
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                                <div class="panel-body">
                                                                    <div class="col-md-12 Quizzes-model m-b-10">
                                                                        <a href="#"> Quize1 <span> 2015-2016</span></a>
                                                                    </div>

                                                                    <div class="col-md-12 Quizzes-model m-b-10">
                                                                        <a href="#"> Quize2 <span> 2015-2016</span></a>
                                                                    </div>
                                                                    <div class="col-md-12 Quizzes-model m-b-10">
                                                                        <a href="#"> Quize1 <span> 2016-2017</span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-default bx-shadow-none">
                                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                                <h4 class="panel-title">
                                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                        Midterms
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                                <div class="panel-body">
                                                                    <div class="col-md-12 Quizzes-model m-b-10">
                                                                        <a href="#"> Midterm <span> 2015-2016</span></a>
                                                                    </div>
                                                                    <div class="col-md-12 Quizzes-model m-b-10">
                                                                        <a href="#"> Midterm <span> 2015-2016</span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-default bx-shadow-none">
                                                            <div class="panel-heading" role="tab" id="headingThree">
                                                                <h4 class="panel-title">
                                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                        Finals
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                                <div class="panel-body">
                                                                    <div class="col-md-12 Quizzes-model m-b-10">
                                                                        <a href="#"> Final <span> 2015-2016</span></a>
                                                                    </div>
                                                                    <div class="col-md-12 Quizzes-model m-b-10">
                                                                        <a href="#"> Final <span> 2015-2016</span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>



                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-info waves-effect waves-light">Save </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="course-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title"> Course </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-5 control-label">Name</label>
                                                    <div class="col-sm-7 ">
                                                        <a href="#" id="course-name" data-type="text" data-pk="1" data-title="Enter course name">IT</a>
                                                    </div>
                                                </div>
                                                <div class="form-group  col-md-12">
                                                    <label class="col-sm-5 control-label">Code</label>
                                                    <div class="col-sm-7">
                                                        <a href="#" id="course-Code" data-type="text" data-pk="1" data-title="Enter course  Code">22</a>
                                                    </div>
                                                </div>
                                                <p> IIOS</p>
                                                <div class="form-group col-md-12">

                                                    <div class="col-sm-7">
                                                        <a href="#" id="IIOS1" data-type="textarea" data-pk="1" data-placeholder="Your IIOS here..." data-title="Enter IIOS">Basic Concepts of information technology</a>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">

                                                    <div class="col-sm-7">
                                                        <a href="#" id="IIOS2" data-type="textarea" data-pk="1" data-placeholder="Your IIOS here..." data-title="Enter IIOS">Using the computer and managing files</a>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-info waves-effect waves-light">Save </button>
                                        </div>
                                    </div>
                                </div>
                            </div>










                            <div class="  card-box  ">


                                <table class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>

                                        <th>Colleges</th>
                                        <th>Course</th>
                                        <th>Exams</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($exams as $exam)
                                    <tr>

                                        <td>{{$exam->course->department->faculity->FACULTY_NAME }}</td>
                                        <td> {{$exam->course->COURSE_NAME}}</td>
                                        <td> {{$exam->EXAM_NAME}} </td>
                                        <th>
                                            <a class="btn btn-primary" href="{{route('doctorProfile.question.create',$exam->id)}}">Question</a>
                                            <a class="btn btn-primary" href="{{route('doctorProfile.show.exam',$exam->id)}}">Show</a>
                                            <a class="btn btn-primary" href="{{route('doctorProfile.print.exam',$exam->id)}}">print</a>
                                            <a class="btn btn-warning" href="{{route('doctorProfile.edit.exam',$exam->id)}}">edit</a>
                                            <a class="btn btn-danger" href="{{route('doctorProfile.calculate.exam',$exam->id)}}">Re-Evaluate</a>
                                            <a class="btn btn-danger" href="{{route('doctorProfile.reopen.exam',$exam->id)}}">Re-Open</a>
                                            <a class="btn btn-danger" href="{{route('doctorProfile.exam.result.downloadResult',$exam->id)}}">Download</a>
                                            <a class="btn btn-primary" href="{{route('doctorProfile.ilosresult.exam',$exam->id)}}">
                                            Ilos</a>
                                            <a class="btn btn-primary" href="{{route('doctorProfile.random_question_bank',['exam_id'=>$exam->id,'course_id'=>$exam->course->id])}}">
                                                Random Questions From Bank
                                            </a>
                                            <a class="btn btn-primary" href="{{route('doctorProfile.print.examhardnessreport',$exam->id)}}">Print Hardness Report </a>
                                            <a class="btn btn-primary" href="{{route('doctorProfile.print.examilosreport',$exam->id)}}">Print Ilos Report </a>


                                        </th>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row -->


                </div>


            </div>
            <!-- end panel -->
        </div>
        <!-- end col-->
    </div>
@endsection
@section('script')

@endsection
