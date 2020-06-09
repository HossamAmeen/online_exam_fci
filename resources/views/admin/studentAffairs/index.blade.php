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

                 @if(session('add') !== null)


                <div class="alert alert-success">
                    {{session('add')}}
                </div>
                @endif
                <div class="col-lg-12">
                    @include('admin.studentAffairs.create')
                    <form action="{{route('studentAffairs.store.custom')}}" method="POST">
                        {{ csrf_field() }}
                        <label for="userName"> user name</label>
                                <input type="text" name="name" parsley-trigger="change" required
                                       placeholder="Enter  name" class="form-control" id="userName">
                                       <label for="userName"> email</label>
                                       <input type="email" name="email" parsley-trigger="change" required
                                              placeholder="Enter email" class="form-control" id="userName">
                                              <label for="userName"> password</label>
                                              <input type="password" name="password" parsley-trigger="change" required
                                                     placeholder="Enter  password" class="form-control" id="userName">
                                                     <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                    </form>
                    <!-- /.modal -->
                </div>
                <!-- end col -->
                <div class="editable-responsive ">
                    <table class="table table-striped" id="datatable-editable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Colleges</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sas as $sa)
                            <tr class="gradeX">
                                <td>{{$sa->SA_NAME}}</td>
                                <td>
                                    <label class="blue-label">{{$sa->faculity->FACULTY_NAME}}</label>
                                </td>
                                <td>
                                    {{$sa->SA_PHONE_NUMBER}}

                                </td>
                                <th class="actions">

                                    <a href="#" class="on-default " data-toggle="modal"
                                        data-target="#con-close-modal_{{$sa->id}}">
                                        <i style="color: white;padding: 8px 10px;
                                        background-color: #10c469 !important;
                                        border: 1px solid #10c469 !important;" class="fa fa-pencil"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#dialog_{{$sa->id}}"
                                        class="on-default ">
                                        <i style="color: white; background-color: #ff5b5b !important; border: 1px solid #ff5b5b !important;padding: 8px 10px;"
                                            class="fa fa-trash-o">
                                        </i>
                                    </a>
                                    <!-- <a  class="on-default btn-info"  > <i class="fa fa-keyboard-o"></i> </a> -->
                                </th>
                                @include('admin.studentAffairs.edit')
                                <?php
                                $route = route('studentAffairs.destroy', $sa->id);
                                $id = $sa->id;
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