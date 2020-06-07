
<div id="con-close-modal_{{$course->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Courses </h4>
            </div>
            <form action="{{route('courses.update',$course->id)}}"  method="post" enctype="multipart/form-data" >

            {{ csrf_field() }}


            <div class="modal-body">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="userName"> Courses Name*</label>
                            <input type="text" name="name" parsley-trigger="change" required value="{{$course->COURSE_NAME}}" class="form-control" id="userName">
                        </div>
                        <div class="form-group col-lg-6 ">
                            <label>Code</label>
                            <input type="text" name="code" placeholder=""  value="{{$course->COURSE_CODE}}" class="form-control">
                            {{--<span class="font-13 text-muted">(999) 999-9999</span>--}}
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Colleges *</label>
                            <select  onchange="department_ajax(this.value,{{$course->DEPARTMENT_ID}} ,{{$course->id}})" name='collage' class="select2 form-control"  required>
                                <optgroup label="Colleges">
                                    @foreach($facultites as $faculty)
                                        <option @if($faculty->id == $course->department->faculity->id) selected @endif value="{{$faculty->id}}">{{$faculty->FACULTY_NAME}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Level *</label>
                            <select  name='level' class="select2 form-control"  required>
                                <option @if($course->COURSES_LEVEL ==1) selected @endif value="1">Level 1</option>
                                <option @if($course->COURSES_LEVEL ==2) selected @endif value="2">Level 2</option>
                                <option @if($course->COURSES_LEVEL ==3) selected @endif value="3">Level 3</option>
                                <option @if($course->COURSES_LEVEL ==4) selected @endif value="4">Level 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Term *</label>
                            <select  name="term" class="form-control select2">
                                <option value="1"> First</option>
                                <option value="2">Second</option>
                            </select>
                        </div>
                        <?php
                            $departments_select=\App\Department::where('FACULTY_ID',$course->department->faculity->id)->get();
                        ?>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Departement *</label>
                            <select name="department" id="depart_{{$course->id}}" class="form-control select2">
                                @foreach($departments_select as $d)
                                    <option @if($d->id == $course->DEPARTMENT_ID) selected @endif value="{{$d->id}}">{{$d->DEPARTMENT_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <h4 class="header-title m-t-0 m-b-30">Add Photo</h4>
                            <input type="file" name="file" class="dropify" data-default-file="{{asset('courses/'.$course->COURSE_IMAGE)}}" />

                        </div><!-- end col -->
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
