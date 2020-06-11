@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card-box p-b-0">
            <h4 class="header-title m-t-0 m-b-30">Create Exam</h4>
            <form id="commentForm" method="post" action="{{route('doctorProfile.exam.store')}}"
                class="form-horizontal ">
                {!! csrf_field() !!}
                <div id="rootwizard" class="pull-in">
                    <ul class="nav nav-tabs navtab-wizard nav-justified bg-muted">
                        <li class="active"><a href="#first" data-toggle="tab">Exam Header</a></li>

                    </ul>
                    <div class="tab-content m-b-0 b-0">
                        <div class="tab-pane fade active in" id="first">

                            <div class="row">
                                <div class="form-group col-lg-4 m-r-5">
                                    <label for="sel1"> Exam Name</label>
                                    <input type="text" name="name" class="form-control select2" required>

                                </div>
                                <div class="form-group col-lg-4 m-r-5">
                                    <label for="sel1">Type Of Exam</label>
                                    <select id='seltype' name='type' class="form-control select2"
                                        onchange="changeExamTimeLabel();">
                                        <option value="1" selected>Quiz</option>
                                        <option value="2">Midterm</option>
                                        <option value="3">Final</option>
                                        <option value="4">Report</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4 m-r-5">
                                    <label for="userName"> Exam Points</label>
                                    <input type="text" name="point" parsley-trigger="change" required placeholder=""
                                        class="form-control" id="userName">
                                </div>
                                {{--<div class="form-group col-lg-4 m-r-5">--}}
                                {{--<label for="sel1"> Year</label>--}}
                                {{--<select class="form-control select2">--}}
                                {{--<option value="AK"> 2010-2011</option>--}}
                                {{--<option value="HI">2013-2014</option>--}}
                                {{--</select>--}}
                                {{--</div>--}}
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 m-r-5">
                                    <label>Start Time </label>
                                    <div class="input-group m-b-15">
                                        <div class="bootstrap-timepicker">
                                            <input id="" type="time" name='start_time' class="form-control" required>
                                        </div>
                                        <span class="input-group-addon bg-primary b-0 text-white"><i
                                                class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <!-- input-group -->
                                </div>
                                <div class="form-group col-lg-4 m-r-5">
                                    <label>Show Time </label>
                                    <div class="input-group m-b-15">
                                        <div class="bootstrap-timepicker">
                                            <input id="" type="time" name='allow_time' class="form-control" required>
                                        </div>
                                        <span class="input-group-addon bg-primary b-0 text-white"><i
                                                class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <!-- input-group -->
                                </div>
                                <div class="form-group col-lg-4 m-r-5">
                                    <label class="control-label ">Start Date</label>
                                    <div class="input-group">
                                        <input type="text" name="date" class="form-control" placeholder="mm/dd/yyyy"
                                            id="datepicker-autoclose" required>
                                        <span class="input-group-addon bg-primary b-0 text-white"><i
                                                class="ti-calendar"></i></span>
                                    </div>
                                    <!-- input-group -->
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 m-r-5">
                                    <label class="control-label ">End Date</label>
                                    <div class="input-group">
                                        <input type="date" name="end_date" class="form-control"
                                            placeholder="mm/dd/yyyy" id="datepicker-autoclose" required>
                                        <span class="input-group-addon bg-primary b-0 text-white"><i
                                                class="ti-calendar"></i></span>
                                    </div>
                                    <!-- input-group -->
                                </div>
                                <div class="form-group col-lg-4 m-r-5">
                                    <label id="examtimelbl">Time Of Exam (Minutes)</label>
                                    <div class="input-group m-b-0">
                                        <div class="bootstrap-timepicker">
                                            <input name="time" type="text" class="form-control" required>
                                        </div>
                                        <span class="input-group-addon bg-primary b-0 text-white"><i
                                                class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <!-- input-group -->
                                </div>
                            </div>
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
                            <label><input type="checkbox" id="camerarequired" name="camerarequired" value="1" />
                                Supervising using camera</label>

                            <br>
                            <br>
                            <!--                                 <div class="row">
                                    <div class="form-group col-lg-3 m-r-5">
                                        <label for="sel1">Number of Easy questions</label>
                                        <input type="number" name="number_easy_question" class="form-control select2" value="0">
                                    </div>
                                    <div class="form-group col-lg-3 m-r-5">
                                        <label for="sel1">Number of Medium questions</label>
                                        <input type="number" name="number_medium_question" class="form-control select2" value="0">
                                    </div>
                                    <div class="form-group col-lg-3 m-r-5">
                                        <label for="sel1">Number of Hard questions</label>
                                        <input type="number" name="number_hard_question" class="form-control select2" value="0">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-lg-2 m-r-5">
                                        <label for="sel1">Number of Choose questions</label>
                                        <input type="number" name="number_choose_question" class="form-control select2" value="0">
                                    </div>
                                    <div class="form-group col-lg-2 m-r-5">
                                        <label for="sel1">Number of true and false questions</label>
                                        <input type="number" name="number_true_and_false _question" class="form-control select2" value="0">
                                    </div>
                                    <div class="form-group col-lg-2 m-r-5">
                                        <label for="sel1">Number of Complete questions</label>
                                        <input type="number" name="number_complete_question" class="form-control select2" value="0">
                                    </div>
                                    <div class="form-group col-lg-2 m-r-5">
                                        <label for="sel1">Number of Write Code questions</label>
                                        <input type="number" name="number_write_code_question" class="form-control select2" value="0">
                                    </div>
                                    <div class="form-group col-lg-2 m-r-5">
                                        <label for="sel1">Number of Define questions</label>
                                        <input type="number" name="number_define_question" class="form-control select2" value="0">
                                    </div>
                                </div> -->
                            <div class="row">
                                <div class="form-group col-lg-4 m-r-5"
                                    style="border: 1px solid gray;border-radius: 20px;padding: 10px;">
                                    <label for="sel1">Choose questions</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="sel1">Easy</label>
                                            <input type="number" name="number_choose_easy_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Meduim</label>
                                            <input type="number" name="number_choose_meduim_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Hard</label>
                                            <input type="number" name="number_choose_hard_question"
                                                class="form-control select2" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 m-r-5"
                                    style="border: 1px solid gray;border-radius: 20px;padding: 10px;">
                                    <label for="sel1">True And False questions</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="sel1">Easy</label>
                                            <input type="number" name="number_true_and_false_easy_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Meduim</label>
                                            <input type="number" name="number_true_and_false_meduim_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Hard</label>
                                            <input type="number" name="number_true_and_false_hard_question"
                                                class="form-control select2" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 m-r-5"
                                    style="border: 1px solid gray;border-radius: 20px;padding: 10px;">
                                    <label for="sel1">Write Code questions</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="sel1">Easy</label>
                                            <input type="number" name="number_write_code_easy_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Meduim</label>
                                            <input type="number" name="number_write_code_meduim_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Hard</label>
                                            <input type="number" name="number_write_code_hard_question"
                                                class="form-control select2" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 m-r-5"
                                    style="border: 1px solid gray;border-radius: 20px;padding: 10px;">
                                    <label for="sel1">Complete questions</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="sel1">Easy</label>
                                            <input type="number" name="number_complete_easy_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Meduim</label>
                                            <input type="number" name="number_complete_meduim_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Hard</label>
                                            <input type="number" name="number_complete_hard_question"
                                                class="form-control select2" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 m-r-5"
                                    style="border: 1px solid gray;border-radius: 20px;padding: 10px;">
                                    <label for="sel1">Define questions</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="sel1">Easy</label>
                                            <input type="number" name="number_define_easy_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Meduim</label>
                                            <input type="number" name="number_define_meduim_question"
                                                class="form-control select2" value="0">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sel1">Hard</label>
                                            <input type="number" name="number_define_hard_question"
                                                class="form-control select2" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="pager m-b-0 wizard">
                            <li class="save "><button type="submit"
                                    class="btn btn-success waves-effect waves-light">Save</button>
                            </li>
                            {{--<li class="add"><a href="#" class="btn btn-warning waves-effect waves-light"> Add</a>--}}
                            {{--</li>--}}
                            {{--<li class="view"><a href="exam.html" class="btn btn-primary waves-effect waves-light">View</a>--}}
                            {{--</li>--}}
                            {{--<li class="next"><a href="#" class="btn btn-primary waves-effect waves-light">Next</a>--}}
                            {{--</li>--}}
                        </ul>
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
                                        id="Question">
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

<script type="text/javascript">
    function changeExamTimeLabel()
        {

          var e = document.getElementById("seltype");
          var typevalue = e.options[e.selectedIndex].value;


          if(typevalue==4)
          {

            document.getElementById("examtimelbl").textContent ="Time Of Exam (days)";

          }
          else
          {

                document.getElementById("examtimelbl").innerHTML='Time Of Exam (Minutes)';

            }
        };
        $(document).ready(function() {
            $('form').parsley();
        });
</script>
<script>
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
</script>
<script>
    jQuery(document).ready(function() {
            //advance multiselect start
            $('#my_multi_select3').multiSelect({
                selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                afterInit: function(ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';
                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });
                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function() {
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
        }, function(start, end, label) {
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
        $('#select-box').change(function() {
            dropdown = $('#select-box').val();
            //first hide all tabs again when a new option is selected
            $('.tab-content1').hide();
            //then show the tab content of whatever option value was selected
            $('#' + "tab-" + dropdown).show();
        });
</script>
<script>
    function department_ajax(val,depart,id){
            $.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '{{route('students.getDepartment')}}', //Your form processing file URL
                data      : {id:val,_token:"{{csrf_token()}}",depart:depart}, //Forms name
//              dataType  : 'json',
                success   : function(data) {
//                    $('#depart').val(null).trigger("change")
                    srt=''
                    if(id)
                    {
                        $('#depart_'+id).select2('destroy');
                        $('#depart_'+id).html(data)
                        $('#depart_'+id).select2();
//                        courses_ajax(depart,id)
                    }else
                    {
                        $('#depart').select2('destroy');
                        $('#depart').html(data)
                        $('#depart').select2();

                    }
                }
            });
        }
        function courses_ajax(department_id,id)
        {
            $.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '{{route('doctor.getCourses')}}', //Your form processing file URL
                data      : {_token:"{{csrf_token()}}",depart:department_id}, //Forms name
//              dataType  : 'json',
                success   : function(data) {

//                    srt=''
                    if(id)
                    {
                        $('#courses_'+id).select2('destroy');
                        $('#courses_'+id).html(data)
                        $('#courses_'+id).select2();

                    }else
                    {
                        $('#courses').select2('destroy');
                        $('#courses').html(data)
                        $('#courses').select2();

                    }
                }
            });
        }
</script>
@endsection