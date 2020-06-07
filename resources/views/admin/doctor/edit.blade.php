<div id="con-close-modal_{{$staff->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Doctor </h4>
            </div>
            <form action="{{route('doctor.update',$staff->id)}}"  method="post" data-parsley-validate novalidate enctype="multipart/form-data">

            {{ csrf_field() }}

            {{ method_field('PUT') }}
            <div class="modal-body">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="userName"> Doctor Name*</label>
                            <input type="text" name="name" parsley-trigger="change" required value="{{$staff->STAFF_NAME}}" class="form-control" id="userName">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="emailAddress">Email address*</label>
                            <input type="email" name="email" parsley-trigger="change" value="{{$staff->user->email}}" required placeholder="Enter email" class="form-control" id="emailAddress">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="pass1">Password*</label>
                            <input id="pass1" name="password" type="password" placeholder="Password" required class="form-control">
                        </div>

                        <div class="form-group col-lg-6 ">
                            <label>Phone</label>
                            <input type="text" name="code" placeholder=""  value="{{$staff->phone}}" class="form-control">
                            {{--<span class="font-13 text-muted">(999) 999-9999</span>--}}
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Colleges *</label>
                            <select  onchange="department_ajax(this.value,{{$staff->DEPARTMENT_ID}} ,{{$staff->id}})" name='collage' class="select2 form-control"  required>
                                    @foreach($faculites as $faculty)
                                        <option @if($faculty->id == $staff->FACULTY_ID) selected @endif value="{{$faculty->id}}">{{$faculty->FACULTY_NAME}}</option>
                                    @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="row">

                        <?php
                            $departments_select=\App\Department::where('FACULTY_ID',$staff->department->faculity->id)->get();
                        ?>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Departement *</label>
                            <select onchange="courses_ajax(this.value,{{$staff->id}})" name="department" id="depart_{{$staff->id}}" class="form-control select2">
                                @foreach($departments_select as $d)
                                    <option @if($d->id == $staff->DEPARTMENT_ID) selected @endif value="{{$d->id}}">{{$d->DEPARTMENT_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <?php
                        $courses=$staff->courses;
                    ?>
                    <div class="form-group col-lg-6">
                        <label for="sel1">Select Courses *</label>
                        <select class="select2 select2-multiple" name='courses[]' id="courses_{{$staff->id}}" multiple="multiple" required>
                            @foreach($courses as $course)
                                <option selected value="{{$course->id}}">{{$course->COURSE_NAME}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info waves-effect waves-light">Save </button>
            </div>
            </form>
        </div>
    </div>
</div>
