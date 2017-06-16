@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs" style="margin-bottom: -11px!important;">
                            <li class=""><a href="{{route('topic-list')}}"><h5>My Topics</h5></a></li>
                            <li><a href="{{route('browse-topic-list')}}"><h5>Browse Topics</h5></a></li>
                            <li class="active"><a href="#tab2default" data-toggle="tab"><h5>Statistics</h5></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">

                        <div class="tab-content">
                            <div class="tab-pane fade " id="tab1default">&nbsp;</div>
                            <div class="tab-pane fade " id="tab2default"></div>

                            <div class="tab-pane fade in active" id="tab2default">
                                <ul class="nav nav-tabs" style="margin-bottom: -11px!important;">
                                    <li class="nav-item active"><a href="{{route('example-statistics')}}"><h5>Example Statistics</h5></a></li>
                                    <li class="nav-item"><a href="{{route('quiz-statistics')}}"><h5>Quiz Statisticswe</h5></a></li>
                                </ul>

                                <div class="tab-content">
                                    &nbsp;@yield('left')
                                     @yield('right')
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection