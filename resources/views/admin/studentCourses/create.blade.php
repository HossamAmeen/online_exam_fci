@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-body">
                <form action="{{route('studentsCourse.import')}}" method="post" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-6 ">

                            <div class="form-group">
                                <div class="">
                                    <label>faculty</label>
                                    <select class="form-control" name="faculty"
                                        onchange="courses_select_ajax(this.value);students_ajax(this.value)" required>
                                        {{-- <option value="">Select Faculty</option> --}}
                                        @foreach($faculties as $faculty)
                                        <option value="{{$faculty->id}}">{{$faculty->FACULTY_NAME}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 ">

                            <div class="form-group">
                                <div class="">
                                    <label> Select course in  faculty</label>
                                    <select class="form-control" name="course_id" id="coursesSelect" required>
                                        {{-- <option value="">Select course</option> --}}

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($studentNotFound))
                    <div class="alert alert-danger" role="alert">
                        this students don't register in the system

                        @foreach ($studentNotFound as $item)

                        {{$item}} <br>
                    </div>
                    @endforeach

                    @endif
                    @if(session('addStudent') !== null)


                    <div class="alert alert-success">
                        {{session('addStudent')}}
                    </div>
                    @endif
                    @if(session('status') !== null)


                    <div class="alert alert-success">
                        {{session('status')}}
                    </div>
                    @endif


                    {!! csrf_field()!!}
                    <div class="col-md-11" style="margin-bottom: 30px">
                        <div class="dropdown pull-right">
                        </div>
                        <h4 class="header-title m-t-0 m-b-30">Import Excel Sheet</h4>
                        <input type="file" name="student_sheet" class="dropify" data-max-file-size="1M" required />
                    </div>
                    <div class="col-md-12 text-center m-t-30">

                        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>

                    </div>
                </form>
                <form action="{{route('studentCourses.store')}}" method="post">
                    {!! csrf_field()!!}

                    {{-- <div class="row">
                        <div class="col-md-6 ">

                            <div class="form-group">
                                <div class="">
                                    <label> Faculty</label>
                                    <select class="form-control" name="faculty"
                                        onchange="courses_ajax(this.value);students_ajax(this.value)">
                                        <option value="">Select Faculty</option>
                                        @foreach($faculties as $faculty)
                                        <option value="{{$faculty->id}}">{{$faculty->FACULTY_NAME}}</option>
                    @endforeach
                    </select>
            </div>
        </div>
    </div>
</div> --}}
{{-- <div class="row">
    <div class="col-md-6 ">

        <p class="list-of-student-p m-b-20"> List Of Students</p>

        <div class="list-of-student">
            <div class="form-group">
                <div class="checkbox">
                    <input id="remember-1" type="checkbox" class="selectall">
                    <label for="remember-1"> Select All </label>
                </div>
            </div>

            <div id="students">

            </div>


        </div>

    </div>
    <div class="col-md-6 ">

        <p class="list-of-student-p m-b-20"> List Of Cources</p>

        <div class="list-of-student">
            <div class="form-group">
                <div class="checkbox">
                    <input id="remember-5" type="checkbox" class="selectall2">
                    <label for="remember-5"> Select All </label>
                </div>
            </div>

            <div id="courses">

            </div>


        </div>

    </div>

    <div class="col-md-12 text-center m-t-30">

        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>

    </div>

</div> --}}
</form>

</div>


</div>
<!-- end: panel body -->
</div>
<!-- end panel -->
</div>
@endsection

@section('script')
<script>
    function courses_ajax(faculty_id, id) {
            $.ajax({ 
                //Process the form using $.ajax()
                type: 'POST', //Method type
                url: '{{route('studentCourses.getCourses')}}', //Your form processing file URL
                data: {_token: "{{csrf_token()}}", faculty_id: faculty_id}, //Forms name
                success: function (data) {

                    if (id) {
                        $('#courses_' + id).select2('destroy');
                        $('#courses_' + id).html(data)
                        $('#courses_' + id).select2();

                    } else {
                      //  $('#courses').select2('destroy');
                        $('#courses').html(data)

                    }
                }
            });
        }

        function courses_select_ajax(faculty_id) {
            $.ajax({ 
                //Process the form using $.ajax()
                type: 'get', //Method type
                url: '{{route('studentCourses.getCoursesSelect')}}', //Your form processing file URL
                data: {faculty_id: faculty_id}, //Forms name
                success: function (data) {
                        console.log(data);
                        $('#coursesSelect')
                        .find('option')
                        .remove();
                        data.forEach(myFunction);
                    
                        function myFunction(item, index) {
                            console.log(item);
                            var o = new Option(item.COURSE_NAME, item.id);
                        // $(o).html("option text");
                       
                        $("#coursesSelect").append(o);  

                        }
                      
                          
                }
            });
        }

    function students_ajax(faculty_id, id) {
            $.ajax({ //Process the form using $.ajax()
                type: 'POST', //Method type
                url: '{{route('studentCourses.getStudent')}}', //Your form processing file URL
                data: {_token: "{{csrf_token()}}", faculty_id: faculty_id}, //Forms name
                success: function (data) {

                    if (id) {
                        $('#courses_' + id).select2('destroy');
                        $('#courses_' + id).html(data)
                        $('#courses_' + id).select2();

                    } else {
                    //$('#courses').select2('destroy');
                        $('#students').html(data)
                  //  $('#courses').select2();

                    }
                }
            });
        }

</script>
<script>
    $(".selectall2").click(function () {
            $(".individual").prop("checked", $(this).prop("checked"));
        });
</script>
<script>
    $(".selectall").click(function () {
            $(".individual2").prop("checked", $(this).prop("checked"));
        });
</script>
@endsection