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
                        @include('admin.doctor.create')
                        <!-- /.modal -->
                    </div>
                    <!-- end col -->
                    <div class="editable-responsive ">
                        <table class="table table-striped" id="datatable-editable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Colleges</th>
                                <th>Courses</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($staffs as $staff)
                            <tr class="gradeX">
                                <td>{{$staff->STAFF_NAME}}</td>
                                <td>
                                  <label class="blue-label">{{$staff->department->faculity->FACULTY_NAME}}</label>
                                </td>
                                <td>
                                    @foreach($staff->courses as $course)
                                        <label class="blue-label">{{$course->COURSE_NAME}}</label>
                                    @endforeach

                                </td>
                                <th class="actions">

                                    <a href="#" class="on-default " data-toggle="modal"
                                       data-target="#con-close-modal_{{$staff->id}}">
                                        <i style="color: white;padding: 8px 10px;background-color: #10c469 !important;border: 1px solid #10c469 !important;
" class="fa fa-pencil"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#dialog_{{$staff->id}}"
                                       class="on-default ">
                                        <i style="color: white; background-color: #ff5b5b !important; border: 1px solid #ff5b5b !important;padding: 8px 10px;"
                                           class="fa fa-trash-o">
                                        </i>
                                    </a>
                                    <!-- <a  class="on-default btn-info"  > <i class="fa fa-keyboard-o"></i> </a> -->
                                </th>
                                  @include('admin.doctor.edit')
                                <?php
                                $route = route('doctor.destroy', $staff->id);
                                $id = $staff->id;
                                $message = "Do You Want To Delete This Doctor ?";
                                ?>
                                @include('layouts.delete')
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
        function department_ajax(val,depart,id){
            $.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '{{route('students.getDepartment')}}', //Your form processing file URL
                data      : {id:val,_token:"{{csrf_token()}}",depart:depart}, //Forms name
//              dataType  : 'json',
                success   : function(data) {
//                    $('#depart').val(null).trigger("change")
                    srt=''
                    if(id)
                    {
                        $('#depart_'+id).select2('destroy');
                        $('#depart_'+id).html(data)
                        $('#depart_'+id).select2();
//                        courses_ajax(depart,id)
                    }else
                    {
                        $('#depart').select2('destroy');
                        $('#depart').html(data)
                        $('#depart').select2();

                    }
                }
            });
        }
        function courses_ajax(department_id,id)
        {
            $.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '{{route('doctor.getCourses')}}', //Your form processing file URL
                data      : {_token:"{{csrf_token()}}",depart:department_id}, //Forms name
//              dataType  : 'json',
                success   : function(data) {

//                    srt=''
                    if(id)
                    {
                        $('#courses_'+id).select2('destroy');
                        $('#courses_'+id).html(data)
                        $('#courses_'+id).select2();

                    }else
                    {
                        $('#courses').select2('destroy');
                        $('#courses').html(data)
                        $('#courses').select2();

                    }
                }
            });
        }
    </script>
@endsection
