<a class="btn btn-success btn-rounded w-md waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Add Courses </a>
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add Courses </h4>
            </div>
            <form action="{{route('courses.store')}}" method="post" data-parsley-validate novalidate enctype="multipart/form-data">
                {!! csrf_field() !!}
            <div class="modal-body">
                <div class="row">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="userName"> Courses Name*</label>
                                <input type="text" name="name" parsley-trigger="change" required placeholder="Enter  name" class="form-control" id="userName">
                            </div>
                            <div class="form-group col-lg-6 ">
                                <label>Code</label>
                                <input type="text" name="code" placeholder=""  class="form-control">
                                {{--<span class="font-13 text-muted">(999) 999-9999</span>--}}
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sel1">Select Colleges *</label>
                                <select onchange="department_ajax(this.value)" name='collage' class="select2 form-control"  required>
                                  <option value="">Select Faculty</option>

                                        @foreach($facultites as $faculty)
                                        <option value="{{$faculty->id}}">{{$faculty->FACULTY_NAME}}</option>
                                        @endforeach

                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sel1">Level *</label>
                                <select  name='level' class="select2 form-control"  required>
                                    <option value="1">Level 1</option>
                                    <option value="2">Level 2</option>
                                    <option value="3">Level 3</option>
                                    <option value="4">Level 4</option>
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
                            <div class="form-group col-lg-6">
                                <label for="sel1">Select Departement *</label>
                                <select name="department" id="depart" class="form-control select2">

                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4 class="header-title m-t-0 m-b-30">Add Photo</h4>
                                <input type="file" name="file" class="dropify" data-default-file="{{asset('assets/images/gallery/1.jpg')}}" />
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
