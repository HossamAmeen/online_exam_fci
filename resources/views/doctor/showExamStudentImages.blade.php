@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <h3 style="text-align:center">Student Name:{{$student->STUDENT_NAME}}</h3>

                        <table class="table table-bordered table-responsive">

                            @foreach($studentExamImageslist as $k=>$stim)
                                <tr>
                                    <td>
                                        <img src="{{asset($stim->path)}}" alt="" />
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
@endsection
@section('script')

@endsection
