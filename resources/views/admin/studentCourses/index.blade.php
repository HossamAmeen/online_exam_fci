@extends('layouts.app')

@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-body">

                <div class="col-lg-12">
                    <a href="{{route('studentCourses.create')}}" class="btn btn-success">Register Student</a>
                </div><!-- end col -->
				<br/>
				<hr/>
                <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <div class="">
                                    <label> Faculty</label>
                                    <select class="form-control" name="faculty"
                                        onchange="courses_select_ajax(this.value);students_ajax(this.value)" id="faculties" required>
                                        {{-- <option value="">Select Faculty</option> --}}
                                        @foreach($faculties as $faculty)
                                        <option value="{{$faculty->id}}">{{$faculty->FACULTY_NAME}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <div class="">
                                    <label> Select course</label>
                                    <select class="form-control" name="course_id" id="coursesSelect" required>
                                        {{-- <option value="">Select course</option> --}}

                                    </select>
                                </div>
                            </div>
                        </div>
						<div class="col-md-2">
							<a href="#" class="btn btn-primary" onClick="loadRegisterations();">Show</a>
						</div>
                    </div>
				<hr/>
                 <div class="editable-responsive " id="content">
                   <?php /*?>
                    <!-- datatable-editable -->
                    <table class="table table-striped" id="faculty">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>StudentName</th>
                                <th>Exam</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Student_cource_exams as $k=>$Student_cource_exam )
                            <tr class="gradeX">
                                <th>{{$Student_cource_exam->course->COURSE_NAME ?? ""}}</th>
                                @if(isset($Student_cource_exam->student))
                                <th> {{$Student_cource_exam->student->STUDENT_NAME}}</th>
                                @else
                                <th></th>
                                @endif
                                <th>{{$Student_cource_exam->Total_Student_Score}}</th>
                                <th class="actions">

                                    <a href="#" data-toggle="modal" data-target="#dialog_{{$Student_cource_exam->id}}"
                                        class="on-default ">
                                        <i style="color: white; background-color: #ff5b5b !important; border: 1px solid #ff5b5b !important;padding: 8px 10px;"
                                            class="fa fa-trash-o">
                                        </i>
                                    </a>
                                    <!-- <a  class="on-default btn-info"  > <i class="fa fa-keyboard-o"></i> </a> -->
                                </th>

                                <?php
                                    $route=route('ilos.destroy', $Student_cource_exam->id);
                                    $id= $Student_cource_exam->id;
                                    $message="Do You Want To Delete This Registeration ?";
                                    ?>
                                @include('layouts.delete')
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
					<?php */?>
                </div>
								
            </div>
            <!-- end: panel body -->

        </div> <!-- end panel -->
    </div> <!-- end col-->
</div>

@endsection
@section('script')
<script>
    // function courses_ajax(faculty_id, id) {
    //         $.ajax({ 
    //             //Process the form using $.ajax()
    //             type: 'POST', //Method type
    //             url: '{{route('studentCourses.getCourses')}}', //Your form processing file URL
    //             data: {_token: "{{csrf_token()}}", faculty_id: faculty_id}, //Forms name
    //             success: function (data) {

    //                 if (id) {
    //                     $('#courses_' + id).select2('destroy');
    //                     $('#courses_' + id).html(data)
    //                     $('#courses_' + id).select2();

    //                 } else {
    //                   //  $('#courses').select2('destroy');
    //                     $('#courses').html(data)

    //                 }
    //             }
    //         });
    //     }

		function loadRegisterations()
		{
			var faculties=document.getElementById('faculties');
			var faculty_id=faculties.options[faculties.selectedIndex].value;
			
			var courses=document.getElementById('coursesSelect');
			var course_id=courses.options[courses.selectedIndex].value;
			alert(faculty_id);
			alert(course_id);
			$.ajax({ 
                //Process the form using $.ajax()
                type: 'get', //Method type
                url: '{{route('studentCourses.loadregisterations')}}', //Your form processing file URL
                data: {faculty_id: faculty_id}, //Forms name
			success: function (data) {
				
				$("#content").html(data);
			}
			});
			
		}
        function courses_select_ajax(faculty_id) {
            $.ajax({ 
                //Process the form using $.ajax()
                type: 'get', //Method type
                url: '{{route('studentCourses.getCoursesSelect')}}', //Your form processing file URL
                data: {faculty_id: faculty_id}, //Forms name
                success: function (data) {
                        console.log(data);
                        $('#coursesSelect')
                        .find('option')
                        .remove();
                        data.forEach(myFunction);
                    
                        function myFunction(item, index) {
                            console.log(item);
                            var o = new Option(item.COURSE_NAME, item.id);
                        // $(o).html("option text");
                       
                        $("#coursesSelect").append(o);  

                        }
                      
                          
                }
            });
        }

    // function students_ajax(faculty_id, id) {
    //         $.ajax({ //Process the form using $.ajax()
    //             type: 'POST', //Method type
    //             url: '{{route('studentCourses.getStudent')}}', //Your form processing file URL
    //             data: {_token: "{{csrf_token()}}", faculty_id: faculty_id}, //Forms name
    //             success: function (data) {

    //                 if (id) {
    //                     $('#courses_' + id).select2('destroy');
    //                     $('#courses_' + id).html(data)
    //                     $('#courses_' + id).select2();

    //                 } else {
    //                 //$('#courses').select2('destroy');
    //                     $('#students').html(data)
    //               //  $('#courses').select2();

    //                 }
    //             }
    //         });
    //     }

</script>
<script>
    $(".selectall2").click(function () {
            $(".individual").prop("checked", $(this).prop("checked"));
        });
</script>
<script>
    $(".selectall").click(function () {
            $(".individual2").prop("checked", $(this).prop("checked"));
        });
</script>
<script>
    (function ($) {

            'use strict';

            var EditableTable = {

                options: {
                    addButton: '#addToTable',
                    table: '#faculty',
                    dialog: {
                        wrapper: '#dialog',
                        cancelButton: '#dialogCancel',
                        confirmButton: '#dialogConfirm',
                    }
                },

                initialize: function () {
                    this
                        .setVars()
                        .build()
                        .events();
                },

                setVars: function () {
                    this.$table = $(this.options.table);
                    this.$addButton = $(this.options.addButton);

                    // dialog
                    this.dialog = {};
                    this.dialog.$wrapper = $(this.options.dialog.wrapper);
                    this.dialog.$cancel = $(this.options.dialog.cancelButton);
                    this.dialog.$confirm = $(this.options.dialog.confirmButton);

                    return this;
                },

                build: function () {
                    this.datatable = this.$table.DataTable({
                        aoColumns: [
                            null,
                            null,
                            null,
                            {"bSortable": false}
                        ]
                    });

                    window.dt = this.datatable;

                    return this;
                },

                events: function () {
                    var _self = this;

                    this.$table
                        .on('click', 'a.save-row', function (e) {
                            e.preventDefault();

                            _self.rowSave($(this).closest('tr'));
                        })
                        .on('click', 'a.cancel-row', function (e) {
                            e.preventDefault();

                            _self.rowCancel($(this).closest('tr'));
                        })
                        .on('click', 'a.edit-row', function (e) {
                            e.preventDefault();

                            _self.rowEdit($(this).closest('tr'));
                        })
                        .on('click', 'a.remove-row', function (e) {
                            e.preventDefault();

                            var $row = $(this).closest('tr');

                            $.magnificPopup.open({
                                items: {
                                    src: _self.options.dialog.wrapper,
                                    type: 'inline'
                                },
                                preloader: false,
                                modal: true,
                                callbacks: {
                                    change: function () {
                                        _self.dialog.$confirm.on('click', function (e) {
                                            e.preventDefault();

                                            _self.rowRemove($row);
                                            $.magnificPopup.close();
                                        });
                                    },
                                    close: function () {
                                        _self.dialog.$confirm.off('click');
                                    }
                                }
                            });
                        });

                    this.$addButton.on('click', function (e) {
                        e.preventDefault();

                        _self.rowAdd();
                    });

                    this.dialog.$cancel.on('click', function (e) {
                        e.preventDefault();
                        $.magnificPopup.close();
                    });

                    return this;
                },

                // ==========================================================================================
                // ROW FUNCTIONS
                // ==========================================================================================
                rowAdd: function () {
                    this.$addButton.attr({'disabled': 'disabled'});

                    var actions,
                        data,
                        $row;

                    actions = [
                        '<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>',
                        '<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>',
                        '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>',
                        '<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>'
                    ].join(' ');

                    data = this.datatable.row.add(['', '', '', actions]);
                    $row = this.datatable.row(data[0]).nodes().to$();

                    $row
                        .addClass('adding')
                        .find('td:last')
                        .addClass('actions');

                    this.rowEdit($row);

                    this.datatable.order([0, 'asc']).draw(); // always show fields
                },

                rowCancel: function ($row) {
                    var _self = this,
                        $actions,
                        i,
                        data;

                    if ($row.hasClass('adding')) {
                        this.rowRemove($row);
                    } else {

                        data = this.datatable.row($row.get(0)).data();
                        this.datatable.row($row.get(0)).data(data);

                        $actions = $row.find('td.actions');
                        if ($actions.get(0)) {
                            this.rowSetActionsDefault($row);
                        }

                        this.datatable.draw();
                    }
                },

                rowEdit: function ($row) {
                    var _self = this,
                        data;

                    data = this.datatable.row($row.get(0)).data();

                    $row.children('td').each(function (i) {
                        var $this = $(this);

                        if ($this.hasClass('actions')) {
                            _self.rowSetActionsEditing($row);
                        } else {
                            $this.html('<input type="text" class="form-control input-block" value="' + data[i] + '"/>');
                        }
                    });
                },

                rowSave: function ($row) {
                    var _self = this,
                        $actions,
                        values = [];

                    if ($row.hasClass('adding')) {
                        this.$addButton.removeAttr('disabled');
                        $row.removeClass('adding');
                    }

                    values = $row.find('td').map(function () {
                        var $this = $(this);

                        if ($this.hasClass('actions')) {
                            _self.rowSetActionsDefault($row);
                            return _self.datatable.cell(this).data();
                        } else {
                            return $.trim($this.find('input').val());
                        }
                    });

                    this.datatable.row($row.get(0)).data(values);

                    $actions = $row.find('td.actions');
                    if ($actions.get(0)) {
                        this.rowSetActionsDefault($row);
                    }

                    this.datatable.draw();
                },

                rowRemove: function ($row) {
                    if ($row.hasClass('adding')) {
                        this.$addButton.removeAttr('disabled');
                    }

                    this.datatable.row($row.get(0)).remove().draw();
                },

                rowSetActionsEditing: function ($row) {
                    $row.find('.on-editing').removeClass('hidden');
                    $row.find('.on-default').addClass('hidden');
                },

                rowSetActionsDefault: function ($row) {
                    $row.find('.on-editing').addClass('hidden');
                    $row.find('.on-default').removeClass('hidden');
                }

            };

            $(function () {
                EditableTable.initialize();
            });

        }).apply(this, [jQuery]);
        function courses_ajax(faculty_id,id)
        {
            $.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '{{route('ilos.getCourses')}}', //Your form processing file URL
                data      : {_token:"{{csrf_token()}}",faculty_id:faculty_id}, //Forms name
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