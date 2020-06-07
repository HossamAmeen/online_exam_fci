<div id="con-close-modal_{{$semester->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit    Semester Description </h4>
            </div>
            <form action="{{route('semester.update',$semester->id)}}" method="post" data-parsley-validate novalidate>

            <div class="modal-body">
                <div class="row">


                    {{ csrf_field() }}

                    {{ method_field('PUT') }}
                        <div class=" col-md-12">

                            <div class="form-group col-md-12">
                                <label for="userName">   Semester Description*</label>
                                <input type="text" name="name" required value="{{$semester->SEMESTER_DESCR}}"
                                       placeholder="Enter name" class="form-control">
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
