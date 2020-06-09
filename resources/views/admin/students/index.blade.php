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
                
                <div class="col-lg-12">
                   
                    <form action="{{route('students.import')}}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
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
                        </div>
                        <div class="col-md-11" style="margin-bottom: 30px">
                            <div class="dropdown pull-right">
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Import Excel Sheet</h4>
                            <input type="file" name="import_file" class="dropify" data-max-file-size="1M" required/>
                        </div>
                        <div class="col-md-1" style="margin-top: 36px">
                            <input type="submit" class="btn btn-primary" value="Submit" />

                        </div>
                    </form>

                    <!-- end col -->
                    @include('admin.students.create')
                    <!-- /.modal -->
                </div>
                <!-- end col -->
                <div class="row">
                    <form action="{{route('students.getStudentIndex')}}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group col-lg-4">
                            <label for="sel1">Select Colleges *</label>
                            <select name="faculty" class="form-control select2" onchange="department_ajax1(this.value)">
                                <option value="">Select Faculty</option>
                                @foreach($faculites as $facu)
                                <option value="{{$facu->id}}"> {{$facu->FACULTY_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="sel1">Select Departement *</label>
                            <select onchange="" name="department" class="form-control select2" id="depart1">

                            </select>
                        </div>
                        <div class="form-group col-lg-1">
                            <label for="sel1"> </label>

                            <input type="submit" value="Enter" class="btn btn-primary">
                        </div>

                    </form>
                </div>
                <div class="editable-responsive ">
                    <table class="table table-striped" id="datatable-editable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Colleges</th>
                                <th>Term</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="rowdata">
                            @if(isset($students))
                            @foreach($students as $student)
                            <tr class="gradeX">

                                <td>{{$student->STUDENT_NAME}}</td>
                                <td>
                                    {{$student->faculty->FACULTY_NAME}}
                                </td>
                                <td>
                                    @if($student->term==1)
                                    First
                                    @else
                                    Second
                                    @endif
                                </td>
                                <td class="actions">
                                    <a href="#" class="on-default " data-toggle="modal"
                                        data-target="#con-close-modal_{{$student->id}}">
                                        <i style="color: white;padding: 8px 10px;background-color: #10c469 !important;border: 1px solid #10c469 !important;
" class="fa fa-pencil"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#dialog_{{$student->id}}"
                                        class="on-default ">
                                        <i style="color: white; background-color: #ff5b5b !important; border: 1px solid #ff5b5b !important;padding: 8px 10px;"
                                            class="fa fa-trash-o">
                                        </i>
                                    </a>
                                </td>
                                @include('admin.students.edit')
                                <?php
                                        $route = route('students.destroy', $student->id);
                                        $id = $student->id;
                                        $message = "Do You Want To Delete This Student ?";
                                        ?>
                                @include('layouts.delete')
                            </tr>
                            @endforeach
                            @endif
                        </tbody>

                    </table>
                    {{--@if(isset($students))--}}

                    {{--{{ $students->links() }}--}}
                    {{--@endif--}}
                </div>
            </div>
            <!-- end: panel body -->
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-->
</div>
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
                url: '{{route('students.getDepartment')}}', //Your form processing file URL
                data: {id: val, _token: "{{csrf_token()}}"}, //Forms name
//              dataType  : 'json',
                success: function (data) {
					//alert(data)
                    $('#depart2').select2('destroy')
                    $('#depart2').html(data)
                    $('#depart2').select2()

                }
            });
        }
        {{--function student_ajax(val){--}}
        {{--$.ajax({ //Process the form using $.ajax()--}}
        {{--type      : 'POST', //Method type--}}
        {{--url       : '{{route('students.getStudent')}}', //Your form processing file URL--}}
        {{--data      : {id:val,_token:"{{csrf_token()}}"}, //Forms name--}}
        {{--//              dataType  : 'json',--}}
        {{--success   : function(data) {--}}

        {{--$("#rowdata").html(data)--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}
</script>
@endsection