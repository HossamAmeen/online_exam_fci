@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="row">


                        <div class="panel">
                            <div class="  card-box  ">


                                <table class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>

                                        <th>Question</th>
                                        <th>Ilos</th>
                                        <th>Percentage</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($questions as $k=>$question)
                                        <tr>
                                            <td>
                                                {!! nl2br(e($question->QUESTION_TEXT)) !!}
                                            </td>
                                            <th>
                                                @foreach($ilos_name[$question->id] as $ilo)
{{--                                                    {{dd($ilos_name[$question->id])}}--}}
                                                    {{$ilo->ilos->ILO_TEXT}}

                                                    <br>
                                                @endforeach
                                            </th>
                                            <th>
                                                @foreach($ilos_name[$question->id] as $ilo)
                                                   {{($ilos[$question->id]/$count) * 100}}<br>
                                                @endforeach
                                            </th>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row -->


                </div>


            </div>
            <!-- end panel -->
        </div>
        <!-- end col-->
    </div>
@endsection
@section('script')

@endsection
