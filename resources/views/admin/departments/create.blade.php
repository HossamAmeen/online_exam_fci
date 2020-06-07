<a class="btn btn-success btn-rounded w-md waves-effect waves-light" data-toggle="modal"
   data-target="#con-close-modal">Add Department </a>
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
                <h4 class="modal-title">Add Department </h4>
            </div>
            <form action="{{route('departments.store')}}" method="post" data-parsley-validate
                  novalidate>

                <div class="modal-body">
                    <div class="row">


                        {!! csrf_field() !!}
                        <div class=" col-md-12">

                            <div class="form-group col-md-12">
                                <label for="userName"> Departmrnt Name*</label>
                                <input type="text" name="name" required
                                       placeholder="Enter name" class="form-control">
                            </div>
                        </div>
                        <div class=" col-md-12">

                            <div class="form-group col-md-12">
                                <label for="sel1">Select Colleges *</label>
                                <select name="college_id" class="select2 form-control select2-choices"
                                        required>

                                    @foreach($faculites as $faculity)
                                        <option value="{{$faculity->id}}">{{$faculity->FACULTY_NAME}}</option>
                                    @endforeach



                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect"
                            data-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
