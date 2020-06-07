<div id="con-close-modal_{{$department->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit    Faculty </h4>
            </div>
            <form action="{{route('departments.update',$department->id)}}" method="post" data-parsley-validate novalidate>

            <div class="modal-body">
                <div class="row">


                    {{ csrf_field() }}

                    {{ method_field('PUT') }}
                        <div class=" col-md-12">

                            <div class="form-group col-md-12">
                                <label for="userName">   Faculty  Name*</label>
                                <input type="text" name="name" required value="{{$department->DEPARTMENT_NAME}}"
                                       placeholder="Enter name" class="form-control">
                            </div>
                        </div>
                    <div class="form-group col-md-12">
                        <label for="sel1">Select Colleges *</label>
                        <select name="college_id" class="select2 form-control select2-choices"
                                required>
                            <optgroup label="Colleges">
                                @foreach($faculites as $faculity)
                                    <option value="{{$faculity->id}}" @if($faculity->id == $department->FACULTY_ID) selected @endif>{{$faculity->FACULTY_NAME}}</option>
                                @endforeach
                            </optgroup>


                        </select>
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
