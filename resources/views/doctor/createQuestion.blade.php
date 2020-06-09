@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box p-b-0">
            @if(session('questions') !== null)


            <div class="alert alert-success">
                {{session('questions')}}
            </div>
            @endif
            <h4 class="header-title m-t-0 m-b-30">Create Question</h4>
            <form method="post" enctype="multipart/form-data" action="{{route('doctorProfile.question.excel')}}">
              {!! csrf_field() !!}
            <label for="sel1" class="form-label">From Excel sheet</label>
            <input type="file" name="question_sheet" parsley-trigger="change"
                class="dropify">
            <button type="submit" class="btn btn-success waves-effect waves-light">upload Excel sheet</button>
            </form>
            <form id="commentForm" method="post"
                action="@if(isset($course_id)) {{route('doctorProfile.question.storeBank')}} @else {{route('doctorProfile.question.store')}} @endif"
                class="form-horizontal " enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if(!isset($course_id)) <input type="hidden" name="exam_id" value="{{$exam->id}}"> @endif
                <div id="rootwizard" class="pull-in">
                    <ul class="nav nav-tabs navtab-wizard nav-justified bg-muted">
                        {{--<li class="active"><a href="#first" data-toggle="tab">Exam Header</a></li>--}}
                        <li class="active"><a href="#second" data-toggle="tab">Create Question</a></li>
                        <li><a href="#third" data-toggle="tab">List Of Questions</a></li>
                    </ul>
                    <div class="tab-content m-b-0 b-0">

                        <div class="tab-pane fade active in" id="second">
                            <label>Choose</label>
                            <select name="choose" class="form-control" onchange="showDiv(this.value)"
                                style="width: 200px">
                                <option value="2">Create</option>
                                @if(!isset($course_id)) <option value="1">Import</option> @endif

                            </select>
                            <br>
                            <div id="div1">

                                <div class="row">
                                    <div class="form-group col-lg-4 m-r-5">
                                        <label for="sel1" class="m-b-15">Question Type</label>
                                        <select name="question_type" class="form-control select2" id="select-box" 
                                        onchange="editChooseInput(this.options[this.selectedIndex].value)">
                                            <option value="1">Choose</option>
                                            <option value="2">true and false</option>
                                            <option value="3">Complete</option>
                                            <option value="4">Write Code</option>
                                            <option value="5">Define</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5  m-r-5">
                                        <label for="sel1" class="form-label">Select IIOS *</label>
                                        <select name="ilos[]" class=" form-control select2 select2-multiple"
                                            multiple="multiple" required>
                                            @foreach($ilos as $ilo)
                                            <option value="{{$ilo->id}}">{{$ilo->ILO_TEXT}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2  m-r-2">
                                        <label for="sel1" class="form-label">Point *</label>
                                        <input type="text" name="point" parsley-trigger="change"
                                            class="form-control select2" required>
                                    </div>
                                    <div class="form-group col-md-2  m-r-2">
                                        <label for="sel1" class="form-label">image</label>
                                        <input type="file" name="question_image" parsley-trigger="change"
                                            class="form-control select2">
                                    </div>
                                </div>
                                <div id="tab-1" class="tab-content1">
                                    <div class="form-group col-lg-12">
                                        <label for="userName">Enter Question</label>
                                        <textarea name="name1" class="form-control" parsley-trigger="change"
                                            class="form-control" id="Question" required></textarea>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-3 m-r-5">
                                            <div class="">
                                                {{--<input  name="choose_answer_1[]" type="hidden" value="0">--}}

                                                <input name="choose_answer_1" type="radio" value="1" >

                                                <label for="checkbox1">
                                                    Enter Choose
                                                    <input type="text" name="choose_text[]" parsley-trigger="change"
                                                        class="form-control" id="Question" >
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="sel1" class="form-label">Choose image</label>
                                                <input type="file" name="choose_image" parsley-trigger="change"
                                                    class="form-control select2">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-3 m-r-5">
                                            <div class="">
                                                {{--<input  name="choose_answer_1[]" type="hidden" value="0">--}}

                                                <input id="checkbox1" name="choose_answer_1" type="radio" value="2" >
                                                {{--<input id="" name="choose_answer[]" type="hidden" value="0">--}}

                                                <label for="checkbox1">
                                                    Enter Choose
                                                    <input type="text" name="choose_text[]" parsley-trigger="change"
                                                        class="form-control" id="Question">
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="sel1" class="form-label">Choose image</label>
                                                <input type="file" name="choose_image_2" parsley-trigger="change"
                                                    class="form-control select2">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-3 m-r-5">
                                            <div class="">
                                                {{--<input  name="choose_answer_1[]" type="hidden" value="0">--}}

                                                <input id="checkbox1" name="choose_answer_1" type="radio" value="3" >
                                                {{--<input id="" name="choose_answer[]" type="hidden" value="0">--}}

                                                <label for="checkbox1">
                                                    Enter Choose
                                                    <input type="text" name="choose_text[]" parsley-trigger="change"
                                                        class="form-control" id="Question">
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="sel1" class="form-label">Choose image</label>
                                                <input type="file" name="choose_image_3" parsley-trigger="change"
                                                    class="form-control select2">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-3 m-r-5">
                                            <div class="">
                                                {{--<input  name="choose_answer_1[]" type="hidden" value="0">--}}

                                                <input id="checkbox1" name="choose_answer_1" type="radio" value="4" >
                                                {{--<input id="" name="choose_answer[]" type="hidden" value="0">--}}

                                                <label for="checkbox1">
                                                    Enter Choose
                                                    <input type="text" name="choose_text[]" parsley-trigger="change"
                                                        class="form-control" id="Question">
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="sel1" class="form-label">Choose image</label>
                                                <input type="file" name="choose_image_4" parsley-trigger="change"
                                                    class="form-control select2">
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div id="tab-2" class="tab-content1">
                                    <div class="form-group col-lg-12">
                                        <label for="userName">Enter Question</label>
                                        <textarea name="name2" class="form-control" parsley-trigger="change"
                                            class="form-control" id="Question"></textarea>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-3 m-r-5">
                                            
                                            <div class="">

                                                <input name="choose_true_false" id="" value="1" type="radio" checked>

                                                <label for="">
                                                    True
    
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-3 m-r-5">
                                            <div class="">

                                                {{-- <input name="choose_false" type="hidden" value="0"> --}}

                                                <input name="choose_true_false" id="" value="0" type="radio">

                                                <label for="">
                                                    False

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-3" class="tab-content1">
                                    <div class="form-group col-lg-12">
                                        <label for="userName">Enter Question</label>
                                        <textarea name="name3" class="form-control" parsley-trigger="change"
                                            class="form-control" id="Question"></textarea>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-3 m-r-5">
                                            <label for="userName">Enter Answer 1</label>
                                            <input type="text" name="complete_1" parsley-trigger="change"
                                                class="form-control" id="Question">
                                        </div>
                                        <div class="form-group col-lg-3 m-r-5">
                                            <label for="userName">Enter Answer 2</label>
                                            <input type="text" name="complete_2" parsley-trigger="change"
                                                class="form-control" id="Question">
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-4" class="tab-content1">
                                    <div class="form-group col-lg-12">
                                        <label for="userName">Enter Question</label>
                                        <textarea name="name4" class="form-control" name="name4" rows="5"></textarea>
                                    </div>
                                </div>
                                <div id="tab-5" class="tab-content1">
                                    <div class="form-group col-lg-12">
                                        <label for="userName">Enter Question</label>
                                        <textarea name="name5" class="form-control" name="name5" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-3 m-r-5">
                                        <div class="">
                                            <select name="hard" class="form-control">
                                                <option value="1">Easy</option>
                                                <option value="2">Medium</option>
                                                <option value="3">Hard</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($course_id))
                                <div class="row">
                                    <div class="form-group col-lg-4 m-r-5">
                                        <label for="sel1">Select Courses *</label>
                                        <select id="courses" class="select2 form-control" name='course_id' required>
                                            @foreach(auth()->user()->staff->courses as $course)
                                            <option value="{{$course->id}}">{{$course->COURSE_NAME}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div id="div2" style="display: none">
                                <label>Questions</label>
                                <select name="question_id" class="form-control">
                                    @foreach($questions as $question)
                                    <option value="{{$question->id}}">{!!$question->QUESTION_TEXT!!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <ul class="pager m-b-0 wizard">
                                <li class="save ">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save
                                    </button>
                                </li>

                            </ul>
                        </div>
                        <div class="tab-pane fade" id="third">
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <table class="table table-bordered table-responsive">
                                        <tr>
                                            <th>Hard </th>
                                            <th>
                                                Question
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                        @foreach($questions_lists as $questions_list)

                                        <tr>
                                            <th>
                                                @if($questions_list->hard == "1")
                                                E
                                                @elseif($questions_list->hard == "2")
                                                M
                                                @else
                                                H
                                                @endif
                                            </th>
                                            <th>
                                                {!!$questions_list->QUESTION_TEXT!!}
                                                {{-- {!! nl2br(e($questions_list->QUESTION_TEXT)) !!} --}}
                                            </th>
                                            <th>
                                                @if(!isset($course_id))
                                                <a href="{{route('doctorProfile.question.question',[$questions_list->id,$exam->id])}}"
                                                    class="btn btn-danger">
                                                    X
                                                </a>
                                                <a href="{{route('doctorProfile.question.edit',[$questions_list->id,$exam->id])}}"
                                                    class="btn btn-warning">
                                                    Edit
                                                </a>
                                                @else
                                                <a href="{{route('doctorProfile.delete.bank',$questions_list->id)}}"
                                                    class="btn btn-danger">
                                                    X
                                                </a>
                                                <a href="{{route('doctorProfile.question.edit',[$questions_list->id])}}"
                                                    class="btn btn-warning">
                                                    Edit
                                                </a>
                                                {{--<a href="{{route('doctorProfile.edit.edit',$questions_list->id) }}"--}}
                                                {{--class="btn btn-warning">--}}
                                                {{--Edit--}}
                                                {{--</a>--}}

                                                @endif
                                            </th>
                                        </tr>

                                        {{--<li><a href="#" class="on-default  " data-toggle="modal"--}}
                                        {{--data-target="#con-show-modal"> What does HTML stand for ?</a></li>--}}
                                        @endforeach
                                    </table>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end col -->
</div>
</div>
<!--model show --->
<div id="con-show-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Edit Question </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-4 m-r-1">
                        <label for="sel1" class="m-b-15">Question Type</label>
                        <select class="form-control select2" id="select-box">
                            <option value="6"> Choose</option>
                            <option value="7">true and false</option>
                            <option value="8">Complete</option>
                            <option value="9">Write Code</option>
                            <option value="10">Define</option>
                        </select>
                    </div>
                    <div class="form-group col-md-7">
                        <label for="sel1" class="form-label">Select IIOS *</label>
                        <select class=" form-control select2 select2-multiple" multiple="multiple" required>
                            <optgroup label="Courses">
                                <option value="AK">What does HTML stand for What does HTML stand for</option>
                                <option value="HI">What does HTML stand for</option>
                                <option value="AKk">for</option>
                                <option value="HIk"> iisttttttttttttttttttttttttttt</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div id="tab-6" class="tab-content1">
                    <div class="form-group col-lg-12">
                        <label for="userName">Enter Question</label>
                        <input type="text" name="nick" parsley-trigger="change" class="form-control" id="Question">
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3 m-r-5">
                            <div class="checkbox checkbox-primary">

                                <input id="checkbox1" type="checkbox">

                                <label for="checkbox1">
                                    Enter Choose
                                    <input type="text" name="nick" parsley-trigger="change" class="form-control"
                                        id="Question" >
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 m-r-5">
                            <div class="checkbox checkbox-primary">

                                <input id="checkbox2" type="checkbox">

                                <label for="checkbox2">
                                    Enter Choose
                                    <input type="text" name="nick" parsley-trigger="change" class="form-control"
                                        id="Question">
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 m-r-5">
                            <div class="checkbox checkbox-primary">

                                <input id="checkbox3" type="checkbox">

                                <label for="checkbox3">
                                    Enter Choose
                                    <input type="text" name="nick" parsley-trigger="change" class="form-control"
                                        id="Question">
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 m-r-5">
                            <div class="checkbox checkbox-primary">

                                <input id="checkbox4" type="checkbox">

                                <label for="checkbox4">
                                    Enter Choose
                                    <input type="text" name="nick" parsley-trigger="change" class="form-control"
                                        id="Question">
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="tab-7" class="tab-content1">
                    <div class="form-group col-lg-12">
                        <label for="userName">Enter Question</label>
                        <input type="text" name="nick" parsley-trigger="change" class="form-control" id="Question">
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3 m-r-5">
                            <div class="checkbox checkbox-primary">

                                <input id="checkbox5" type="checkbox">

                                <label for="checkbox5">
                                    True

                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 m-r-5">
                            <div class="checkbox checkbox-primary">

                                <input id="checkbox6" type="checkbox">

                                <label for="checkbox6">
                                    False

                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-8" class="tab-content1">
                    <div class="form-group col-lg-12">
                        <label for="userName">Enter Question</label>
                        <input type="text" name="nick" parsley-trigger="change" class="form-control" id="Question">
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3 m-r-5">
                            <label for="userName">Enter Answer 1</label>
                            <input type="text" name="nick" parsley-trigger="change" class="form-control" id="Question">
                        </div>
                        <div class="form-group col-lg-3 m-r-5">
                            <label for="userName">Enter Answer 2</label>
                            <input type="text" name="nick" parsley-trigger="change" class="form-control" id="Question">
                        </div>
                    </div>
                </div>
                <div id="tab-9" class="tab-content1">
                    <div class="form-group col-lg-12">
                        <label for="userName">Enter Question</label>
                        <textarea class="form-control" rows="5"></textarea>
                    </div>
                </div>
                <div id="tab-10" class="tab-content1">
                    <div class="form-group col-lg-12">
                        <label for="userName">Enter Question</label>
                        <textarea class="form-control" rows="5"></textarea>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info waves-effect waves-light">Save</button>
            </div>
        </div>
    </div>

</div>
<!-- /.modal -->
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{asset('assets/js/ckeditor_admin2/ckeditor.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
            CKEDITOR.replace( 'name1' );
            CKEDITOR.replace( 'name2' );
            CKEDITOR.replace( 'name3' );
            CKEDITOR.replace( 'name4' );
            CKEDITOR.replace( 'name5' );
            $('form').parsley();

        });
        function showDiv(val)
        {
            if(val==1)
            {
                $("#div2").show();
                $("#div1").hide();

            }else
            {
                $("#div1").show();
                $("#div2").hide();

            }
        }
</script>
<script>
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
</script>
<script>
    jQuery(document).ready(function () {
            //advance multiselect start
            $('#my_multi_select3').multiSelect({
                selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                afterInit: function (ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';
                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function (e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });
                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function (e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function () {
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function () {
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });
            // Select2
            $(".select2").select2();
            $(".select2-limiting").select2({
                maximumSelectionLength: 2
            });
        });
        //Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        $("input[name='demo1']").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            postfix: '%'
        });
        $("input[name='demo2']").TouchSpin({
            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            maxboostedstep: 10000000,
            prefix: '$'
        });
        $("input[name='demo3']").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        });
        $("input[name='demo3_21']").TouchSpin({
            initval: 40,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        });
        $("input[name='demo3_22']").TouchSpin({
            initval: 40,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        });
        $("input[name='demo5']").TouchSpin({
            prefix: "pre",
            postfix: "post",
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        });
        $("input[name='demo0']").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        });
        // Time Picker
        jQuery('#timepicker').timepicker({
            defaultTIme: false
        });
        jQuery('#timepicker2').timepicker({
            showMeridian: false
        });
        jQuery('#timepicker3').timepicker({
            minuteStep: 15
        });
        //colorpicker start
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
        $('.colorpicker-rgba').colorpicker();
        // Date Picker
        jQuery('#datepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-inline').datepicker();
        jQuery('#datepicker-multiple-date').datepicker({
            format: "mm/dd/yyyy",
            clearBtn: true,
            multidate: true,
            multidateSeparator: ","
        });
        jQuery('#date-range').datepicker({
            toggleActive: true
        });
        //Date range picker
        $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-default',
            cancelClass: 'btn-primary'
        });
        $('.input-daterange-timepicker').daterangepicker({
            timePicker: true,
            format: 'MM/DD/YYYY h:mm A',
            timePickerIncrement: 30,
            timePicker12Hour: true,
            timePickerSeconds: false,
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-default',
            cancelClass: 'btn-primary'
        });
        $('.input-limit-datepicker').daterangepicker({
            format: 'MM/DD/YYYY',
            minDate: '06/01/2016',
            maxDate: '06/30/2016',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-default',
            cancelClass: 'btn-primary',
            dateLimit: {
                days: 6
            }
        });
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker({
            format: 'MM/DD/YYYY',
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2016',
            maxDate: '12/31/2016',
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-default',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });
        //Bootstrap-MaxLength
        $('input#defaultconfig').maxlength()
        $('input#thresholdconfig').maxlength({
            threshold: 20
        });
        $('input#moreoptions').maxlength({
            alwaysShow: true,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger"
        });
        $('input#alloptions').maxlength({
            alwaysShow: true,
            warningClass: "label label-success",
            limitReachedClass: "label label-danger",
            separator: ' out of ',
            preText: 'You typed ',
            postText: ' chars available.',
            validate: true
        });
        $('textarea#textarea').maxlength({
            alwaysShow: true
        });
        $('input#placement').maxlength({
            alwaysShow: true,
            placement: 'top-left'
        });
</script>
<script type="text/javascript">
    $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong appended.'
            },
            error: {
                'fileSize': 'The file size is too big (1M max).'
            }
        });
</script>
<script>
    //hide all tabs first
        $('.tab-content1').hide();
        //show the first tab content
        $('#tab-1').show();
        $('#select-box').change(function () {
            dropdown = $('#select-box').val();
            //first hide all tabs again when a new option is selected
            $('.tab-content1').hide();

            //then show the tab content of whatever option value was selected
            $('#' + "tab-" + dropdown).show();
            $val = $("#select-box").val();
            document.getElementById("commentForm").reset();
            document.getElementById("select-box").value = $val;


        });
</script>
<script>
    editChooseInput(1);
    function editChooseInput(item){
        if(item == 1)
        $("input[name=choose_answer_1]").prop('required',true);
        else
        $("input[name=choose_answer_1]").prop('required',false);
    }
   
</script>
@endsection
