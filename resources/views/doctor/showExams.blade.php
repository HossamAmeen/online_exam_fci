@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-3 form-group">
                            <select class="form-control" id="exam" onchange="getresult(this.value)">
                                <option value="0"> Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{$exam->id}}">{{$exam->EXAM_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" id="table">

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
    <script>
        function getresult(id) {
            $.ajax({ //Process the form using $.ajax()
                type: 'POST', //Method type
                url: '{{route('doctorProfile.exam.result')}}', //Your form processing file URL
                data: {id: id, _token: "{{csrf_token()}}"}, //Forms name
//              dataType  : 'json',
                success: function (data) {
                    $('#table').html(data)
                }
            });
        }
    </script>
@endsection
