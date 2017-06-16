@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs" style="margin-bottom: -11px!important;">
                            <li class=""><a href="{{route('topic-list')}}"><h5>My Topics</h5></a></li>
                            <li class="active"><a href="#tab2default" data-toggle="tab"><h5>Browse Topics</h5></a></li>
                            <li class=""><a href="{{route('example-statistics')}}"><h5>Statistics</h5></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">

                        <div class="tab-content">
                            <div class="tab-pane fade " id="tab1default">
                                &nbsp;
                            </div>
                            <div class="tab-pane fade in active" id="tab2default">

                                <div class="list-group">
                                    @if(!$browseTopics->isEmpty())
                                        @foreach($browseTopics as $browseTopic)
                                            <a class="list-group-item list-group-item"
                                               href="{{route('subtopic-list',[$browseTopic->topic_id])}}">
                                                <h4 class="list-group-item-heading">{{$browseTopic->topic_name}}</h4>
                                                <p class="list-group-item-text">{{$browseTopic->topic_description}}</p>
                                                <p class="pull_right text-right creted-by-txt list-group-item-text">
                                                    <small>~ @if(isset($browseTopic->users)) {{$browseTopic->users->name}} @endif</small>
                                                </p>
                                            </a>
                                        @endforeach
                                        @if ($browseTopics->hasMorePages())
                                            <div class="list-group-item text-center"
                                                 href="#">{{ $browseTopics->links() }}</div>
                                        @endif
                                    @else
                                        <div class="list-group-item text-center" href="#">No Topics Found</div>
                                    @endif
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