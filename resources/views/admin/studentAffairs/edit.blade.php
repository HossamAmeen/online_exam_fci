<div id="con-close-modal_{{$sa->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Student Affairs </h4>
            </div>
            <form action="{{route('studentAffairs.update',$sa->id)}}"  method="post" data-parsley-validate novalidate enctype="multipart/form-data">

            {{ csrf_field() }}

            {{ method_field('PUT') }}
            <div class="modal-body">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="userName"> Doctor Name*</label>
                            <input type="text" name="name" parsley-trigger="change" required value="{{$sa->SA_NAME}}" class="form-control" id="userName">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="emailAddress">Email address*</label>
                            <input type="email" name="email" parsley-trigger="change" value="{{$sa->user->email}}" required placeholder="Enter email" class="form-control" id="emailAddress">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="pass1">Password*</label>
                            <input id="pass1" name="password" type="password" placeholder="Password" required class="form-control">
                        </div>

                        <div class="form-group col-lg-6 ">
                            <label>Phone</label>
                            <input type="text" name="code" placeholder=""  value="{{$sa->SA_PHONE_NUMBER}}" class="form-control">
                            {{--<span class="font-13 text-muted">(999) 999-9999</span>--}}
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Colleges *</label>
                            <select   name='collage' class="select2 form-control"  required>
                                    @foreach($faculites as $faculty)
                                        <option @if($faculty->id == $sa->FACULTY_ID) selected @endif value="{{$faculty->id}}">{{$faculty->FACULTY_NAME}}</option>
                                    @endforeach
                            </select>
                        </div>

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
