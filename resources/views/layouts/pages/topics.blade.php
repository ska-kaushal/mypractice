@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs" style="margin-bottom: -11px!important;">
                            <li class="active"><a href="#tab1default" data-toggle="tab"><h5>My Topics</h5></a></li>
                            <li><a href="{{route('browse-topic-list')}}"><h5>Browse Topics</h5></a></li>
                            <li class=""><a href="{{route('example-statistics')}}"><h5>Statistics</h5></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">

                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">

                                <div class="list-group">
                                    @if(!$topics->isEmpty())
                                        @foreach($topics as $topic)
                                            <a class="list-group-item list-group-item"
                                               href="{{route('subtopic-list',[$topic->topic_id])}}">
                                                <h4 class="list-group-item-heading">{{$topic->topic_name}}</h4>
                                                <p class="list-group-item-text">{{$topic->topic_description}}</p>
                                            </a>
                                        @endforeach
                                        @if ($topics->hasMorePages())
                                            <div class="list-group-item text-center"
                                                 href="#">{{ $topics->links() }}</div>
                                        @endif
                                    @else
                                        <div class="list-group-item text-center" href="#">No Topics Found</div>
                                    @endif
                                </div>

                            </div>
                            <div class="tab-pane fade" id="tab2default">

                                &nbsp;

                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">

                        <form name="frmAddTopic" action="{{route('topic-post')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input class="form-control" placeholder="Add Topic" name="txtTopicName"
                                       id="txtTopicName">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Add Description" name="txtTopicDesc"
                                          id="txtTopicDesc" row="3"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Topic</button>
                            </div>
                        </form>
                        @include('layouts.errors')

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection