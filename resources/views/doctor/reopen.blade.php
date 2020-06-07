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

                <div class="col-md-12">
                    <div class="row">


                        <div class="panel">
                            <div class="  card-box  ">


                                <table class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>

                                        <th>Student</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($studentExams as $studentExam)
                                        <tr>
                                            <td> {{$studentExam->student->STUDENT_NAME}} </td>
                                            <th>
                                                <a class="btn btn-primary" href="{{route('doctorProfile.exam.reoprn.exam',$studentExam->id)}}">Re-open</a>

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
