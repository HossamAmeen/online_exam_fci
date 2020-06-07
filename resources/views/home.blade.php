@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12 search-box">
            <div class="panel">
                <div class="form-group">
                    <fieldset class="the-fieldset">
                        <H1 style="text-align: center">Welcome {{auth()->user()->name}}</H1>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>
@endsection
