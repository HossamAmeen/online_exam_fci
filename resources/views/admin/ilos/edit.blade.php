<div id="con-close-modal_{{$ilo->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Ilos  </h4>
            </div>
            <form action="{{route('ilos.update',$ilo->id)}}" method="post" data-parsley-validate
                  novalidate>

                <div class="modal-body">
                    <div class="row">


                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <div class="panel">
                            <div class="form-group">

                                <div class="col-md-12">
                                    <div class="col-md-6">

                                        <div class="form-group col-lg-12">
                                            <label for="sel1" class="m-b-15 ">Type Of ILOS *</label>
                                            <select name="type_id" class="form-control select2">
                                                @foreach($ilos_types as $ilos_type)
                                                    <option @if($ilo->ILO_TYPE_ID == $ilos_type->id) selected @endif value="{{$ilos_type->id}}"> {{$ilos_type->ILO_TYPE_DESCR}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{--<div class="form-group col-lg-12">--}}
                                            {{--<label for="sel1" class="m-b-15 ">Faculty *</label>--}}
                                            {{--<select onchange="courses_ajax(this.value)" name="faculty_id" class="form-control select2">--}}
                                                {{--<option value="">Select Faculity</option>--}}
                                                {{--@foreach($faculties as $faculty)--}}
                                                    {{--<option value="{{$faculty->id}}"> {{$faculty->FACULTY_NAME}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                        <div class="form-group col-lg-12">
                                            <label for="sel1" class="m-b-15 ">Select Courses *</label>
                                            <select readonly class="form-control">
                                                <option > {{$ilo->course->COURSE_NAME}}</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group col-lg-12">
                                            <label for="sel1">Write Text *</label>
                                            <textarea name='ilos_name' style="margin: 10px 4.625px 0px 0px; height: 208px; width: 230px;" required="" class="form-control"
                                                      data-parsley-id="50">
                                                {{$ilo->ILO_TEXT}}
                                            </textarea>
                                        </div>

                                    </div>


                                </div>


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
