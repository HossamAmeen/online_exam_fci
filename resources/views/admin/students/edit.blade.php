<div id="con-close-modal_{{$student->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit    Faculty </h4>
            </div>
            <form action="{{route('students.update',$student->id)}}" method="post" data-parsley-validate novalidate>

            <div class="modal-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="userName"> Name*</label>
                            <input type="text" value="{{$student->STUDENT_NAME}}" name="name" parsley-trigger="change" required placeholder="Enter  name" class="form-control" id="userName">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="emailAddress">Email address*</label>
                            <input type="email" name="email" value="{{$student->STUDENT_EMAIL}}" parsley-trigger="change" required placeholder="Enter email" class="form-control" id="emailAddress">
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label for="pass1">Password*</label>
                            <input id="pass1" name="password" parsley-trigger="change" type="password" placeholder="Password"  required class="form-control">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Colleges *</label>
                            <select  name="faculty" class="form-control select2" onchange="department_ajax(this.value)">
                                <option value="">Select Faculty</option>
                                @foreach($faculites as $facu)
                                    <option @if($student->FACULTY_ID == $facu->id) selected @endif value="{{$facu->id}}"> {{$facu->FACULTY_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $departments_select=\App\Department::where('FACULTY_ID',$student->FACULTY_ID)->get();
                        ?>

                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Departement *</label>
                            <select name="department" class="form-control select2" id="depart">
                                @foreach($departments_select as $department)
                                    <option @if($student->DEPARTMENT_ID	 == $department->id) selected @endif value="{{$department->id}}"> {{$department->DEPARTMENT_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Term *</label>
                            <select name="term" class="form-control select2">
                                <option @if($student->term	 == 1  ) selected @endif value="1"> First</option>
                                <option @if($student->term	 == 2  ) selected @endif value="2">Second</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Year *</label>
                            <select name="year" class="form-control select2">
                                <option @if($student->semester	 == '2020 -2021'  ) selected @endif value="2020 -2021"> 2020 -2021</option>
                                <option @if($student->semester	 == '2019 -2020'  ) selected @endif value="2019 -2020"> 2019 -2020</option>
                                <option @if($student->semester	 == '2018 -2019'  ) selected @endif value="2018 -2019"> 2018 -2019</option>
                                <option @if($student->semester	 == '2017 -2018'  ) selected @endif value="2017 -2018">2017-2018</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 ">
                            <label>Code</label>
                            <input type="text" name="phone" placeholder="" value="{{$student->phone}}" class="form-control" data-parsley-id="10">
                            <span class="font-13 text-muted"></span>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="userName"> SNN*</label>
                            <input type="text" name="snn" parsley-trigger="change" value="{{$student->STUDENT_SSN}}" required placeholder="Enter  SNN" class="form-control" id="userName">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info waves-effect waves-light">Edit </button>
            </div>
              </form>
        </div>
    </div>
</div><!-- /.modal -->
