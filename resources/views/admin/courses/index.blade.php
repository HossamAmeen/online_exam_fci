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
                        @include('admin.courses.create')
                        <!-- /.modal -->
                    </div>
                    <!-- end col -->
                    <div class="editable-responsive ">
                        <table class="table table-striped" id="datatable-editable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Colleges</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                            <tr class="gradeX">
                                <td>{{$course->COURSE_NAME}}</td>
                                <td>
                                    <label class="blue-label">{{$course->department->faculity->FACULTY_NAME}}</label>
                                </td>
                                <td>
                                    {{$course->COURSE_CODE}}
                                </td>
                                <th class="actions">

                                    <a href="#" class="on-default " data-toggle="modal"
                                       data-target="#con-close-modal_{{$course->id}}">
                                        <i style="color: white;padding: 8px 10px;background-color: #10c469 !important;border: 1px solid #10c469 !important;
" class="fa fa-pencil"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#dialog_{{$course->id}}"
                                       class="on-default ">
                                        <i style="color: white; background-color: #ff5b5b !important; border: 1px solid #ff5b5b !important;padding: 8px 10px;"
                                           class="fa fa-trash-o">
                                        </i>
                                    </a>
                                    <!-- <a  class="on-default btn-info"  > <i class="fa fa-keyboard-o"></i> </a> -->
                                    
									<a href="{{route('admin.courses.show',['course_id'=>$course->id])}}">show</a>
                                </th>

                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($courses as $course)
                            @include('admin.courses.edit')
                            <?php
                            $route = route('courses.destroy', $course->id);
                            $id = $course->id;
                            $message = "Do You Want To Delete This Course ?";
                            ?>
                            @include('layouts.delete')
                        @endforeach
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


                    }else
                    {
                        $('#depart').select2('destroy');
                        $('#depart').html(data)
                        $('#depart').select2();

                    }
                }
            });
        }
    </script>
@endsection
