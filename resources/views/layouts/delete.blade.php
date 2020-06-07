<div id="dialog_{{$id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class='modal-dialog'>

        <div class='modal-content'>
            <div class='modal-header'>
                Warming
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title text-center'><span style='color: red;'></span></h4>
            </div>
            <div class='modal-body'>
                {{$message}}
            </div>
            <div style='clear: both'></div>
            <div class='modal-footer'>
                <form action="{{$route}}" method="post" style="display: inline;">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <button type="submit" class="btn btn-primary">Yes</button>
                </form>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>

            </div>
        </div>

    </div>
</div><!-- /.modal -->
