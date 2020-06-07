@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                  @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif

                    <div class="col-lg-12">

                    @include('admin.departments.create')
                    </div><!-- end col -->


                    <div class="editable-responsive ">

                        <!-- datatable-editable -->
                        <table class="table table-striped" id="faculty">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Faculty</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $k=>$department)
                                <tr class="gradeX">
                                    <th>{{$k+1}}</th>
                                    <th> {{$department->DEPARTMENT_NAME}}</th>
                                    <th style="">{{$department->faculity->FACULTY_NAME}}</th>
                                    <th class="actions">

                                        <a href="#" class="on-default " data-toggle="modal"
                                           data-target="#con-close-modal_{{$department->id}}">
                                            <i style="color: white;padding: 8px 10px;background-color: #10c469 !important;border: 1px solid #10c469 !important;
" class="fa fa-pencil"></i></a>
                                        <a href="#" data-toggle="modal" data-target="#dialog_{{$department->id}}"
                                           class="on-default ">
                                            <i style="color: white; background-color: #ff5b5b !important; border: 1px solid #ff5b5b !important;padding: 8px 10px;"
                                               class="fa fa-trash-o">
                                            </i>
                                        </a>
                                        <!-- <a  class="on-default btn-info"  > <i class="fa fa-keyboard-o"></i> </a> -->
                                    </th>
                                    @include('admin.departments.edit')
                                    <?php
                                    $route = route('departments.destroy', $department->id);
                                    $id = $department->id;
                                    $message = "Do You Want To Delete This Faculty ?";
                                    ?>
                                    @include('layouts.delete')
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end: panel body -->

            </div> <!-- end panel -->
        </div> <!-- end col-->
    </div>

@endsection
@section('script')
    <script>
        // $(document).ready(function () {
        //
        //     var total = $('#faculty tfoot th').length;
        //
        //     $('#faculty tfoot th').each( function (index) {
        //
        //         if (index !== total - 1) {
        //
        //             $(this).html('<input type="text" class="form-control" style="width: 100%" placeholder="Search" />');
        //         }
        //     } );
        //
        //     var table = $('#faculty').DataTable({
        //
        //         dom: '<"html5buttons" B>lTfgitp',
        //         buttons: [
        //             {
        //                 extend: 'copyHtml5',
        //                 exportOptions: {
        //                     columns: [0, 1 ]
        //                 }
        //             },
        //             {
        //                 extend: 'excelHtml5',
        //                 exportOptions: {
        //                     columns: [0, 1 ]
        //                 }
        //             },
        //             {
        //                 extend: 'pdfHtml5',
        //                 exportOptions: {
        //                     columns: [0, 1 ]
        //                 }
        //             },
        //             'colvis'
        //         ]
        //     });
        //
        //
        //     table.columns().every( function () {
        //         var that = this;
        //
        //         $( 'input', this.footer() ).on( 'keyup change', function () {
        //             if ( that.search() !== this.value ) {
        //                 that
        //                     .search( this.value )
        //                     .draw();
        //             }
        //         });
        //     });
        //
        // });
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

    </script>
@endsection
