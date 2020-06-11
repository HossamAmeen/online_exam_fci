@extends('layouts.app')

@section('content')



<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session('updateStudent') !== null)


                <div class="alert alert-success">
                    {{session('updateStudent')}}
                </div>
                @endif
                @if(session('addNewStudent') !== null)


                <div class="alert alert-success">
                    {{session('addNewStudent')}}
                </div>
                @endif
                <div class="col-lg-12">

                    <form action="{{url('add-new-student')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="sel1">Select Colleges *</label>
                                <select name="faculty" class="form-control select2" required
                                    onchange="department_ajax2(this.value)">
                                    <option value="">Select Faculty</option>
                                    @foreach($faculites as $facu)
                                    <option value="{{$facu->id}}"> {{$facu->FACULTY_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sel1">Select Departement *</label>
                                <select name="department" class="form-control select2" id="depart2" required>

                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label> Select course</label>
                                <select class="form-control select2" name="course_id" id="coursesSelect" required>
                                </select>
                            </div>
                        </div>
                        <label for="userName">student name</label>
                        <input type="text" name="name" parsley-trigger="change" required placeholder="Enter  name"
                            class="form-control" id="userName">
                        <label for="userName"> snn</label>
                        <input type="number" name="snn" parsley-trigger="change" required placeholder="Enter snn"
                            class="form-control" id="userName">


                        <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                    </form>
                    <!-- /.modal -->
                </div>
                <!-- end col -->
                {{-- search form --}}
                <div class="col-lg-12">
                    <h3>search for student</h3>
                    <form action="{{url('search-student')}}" method="POST">
                        {{ csrf_field() }}
                        <label for="userName">student name</label>
                        <input type="text" name="name" parsley-trigger="change" placeholder="Enter  name"
                            class="form-control" id="userName">
                        <label for="userName"> snn</label>
                        <input type="number" name="snn" parsley-trigger="change" required placeholder="Enter snn"
                            class="form-control" id="userName">
                        <button type="submit" class="btn btn-info waves-effect waves-light">search</button>
                    </form>
                </div>

                <!-- end col -->
                {{-- update form --}}
                @if(isset($student))
                <div class="col-lg-12">


                    <form action="{{url('update-student/'.$student->id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="form-group col-lg-6">
                                <label for="sel1">Select Departement *</label>
                                <select name="department" class="form-control select2" id="depart2" required>
                                    @foreach ($departments as $item)

                                    <option value="{{$item->id}}" @if($student->DEPARTMENT_ID == $item->id) selected
                                        @endif> {{$item->DEPARTMENT_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sel1">Select course </label>
                                <select name="course_id" class="form-control select2" id="depart2" >
                                    @foreach ($courses as $item)
                                    <option value="{{null}}" ></option>
                                    <option value="{{$item->id}}"> {{$item->COURSE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <label for="userName">student name</label>
                        <input type="text" name="name" parsley-trigger="change" value="{{$student->STUDENT_NAME}}"
                            required placeholder="Enter  name" class="form-control" id="userName">
                        <label for="userName"> snn</label>
                        <input type="number" name="snn" parsley-trigger="change" value="{{$student->STUDENT_SSN}}"
                            required placeholder="Enter snn" class="form-control" id="userName" required>


                        <button type="submit" class="btn btn-info waves-effect waves-light">update</button>
                    </form>
                    <!-- /.modal -->
                </div>
                <!-- end col -->
                @endif
            </div>
            <!-- end: panel body -->
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-->
</div>
<!-- end row -->

@endsection
@section('script')
<script>
    function department_ajax(val) {
            $.ajax({ //Process the form using $.ajax()
                type: 'POST', //Method type
                url: '{{route('students.getDepartment')}}', //Your form processing file URL
                data: {id: val, _token: "{{csrf_token()}}"}, //Forms name
//              dataType  : 'json',
                success: function (data) {
					//alert(data)
                    $('#depart').select2('destroy')
                    $('#depart').html(data)
                    $('#depart').select2()

                }
            });
        }

        function department_ajax1(val) {
            $.ajax({ //Process the form using $.ajax()
                type: 'POST', //Method type
                url: '{{route('students.getDepartment')}}', //Your form processing file URL
                data: {id: val, _token: "{{csrf_token()}}"}, //Forms name
//              dataType  : 'json',
                success: function (data) {
                    $('#depart1').select2('destroy')
                    $('#depart1').html(data)
                    $('#depart1').select2()

                }
            });
        }
		
		function department_ajax2(val) {
            $.ajax({ //Process the form using $.ajax()
                type: 'POST', //Method type
                url: '{{url('/get/department/edit')}}', //Your form processing file URL
                data: {id: val, _token: "{{csrf_token()}}"}, //Forms name
//              dataType  : 'json',
                success: function (data) {
					//alert(data)
                    $('#depart2').select2('destroy')
                    $('#depart2').html(data)
                    $('#depart2').select2()

                }
            });
            ////////////// get courses
            $.ajax({ 
                //Process the form using $.ajax()
                type: 'get', //Method type
                url: '{{route('get.courses')}}', //Your form processing file URL
                data: {faculty_id: val}, //Forms name
                success: function (data) {
                        // console.log(data);
                        // $('#coursesSelect')
                        // .find('option')
                        // .remove();
                        // data.forEach(myFunction);
                    
                        // function myFunction(item, index) {
                        //     console.log(item);
                        //     var o = new Option(item.COURSE_NAME, item.id);
                        // // $(o).html("option text");                       
                        // $("#coursesSelect").append(o);  

                        // }
                        $('#coursesSelect').select2('destroy')
                        $('#coursesSelect').html(data)
                        $('#coursesSelect').select2()
                          
                }
            });
        }

        function courses_select_ajax(faculty_id) {
            $.ajax({ 
                //Process the form using $.ajax()
                type: 'get', //Method type
                url: '{{route('get.courses')}}', //Your form processing file URL
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
        
</script>
@endsection