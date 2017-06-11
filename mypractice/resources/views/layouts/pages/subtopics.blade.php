@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            Subtopics
                            <span class="pull-right">
                                <a href='{{route('topic-list')}}' class="btn btn-xs btn-primary">
                                   Back
                                </a>
                            </span>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            @if(!$subtopics->isEmpty())
                                @foreach($subtopics as $subtopic)
                                    <a class="list-group-item list-group-item" href="{{route('article-list',[$subtopic->subtopic_id])}}">
                                        <h4 class="list-group-item-heading">{{$subtopic->subtopic_name}}</h4>
                                        <p class="list-group-item-text">{{$subtopic->subtopic_description}}</p>
                                    </a>
                                @endforeach
                                @if ($subtopics->hasMorePages())
                                    <div class="list-group-item text-center" href="#">{{ $subtopics->links() }}</div>
                                @endif
                            @else
                                <div class="list-group-item text-center" href="#">No Subtopic Found</div>
                            @endif

                        </div>
                    </div>

                    <div class="panel-footer">
                        @if($topicDetail->created_by == auth()->id())
                            <form name="frmAddSubTopic" action="{{route('subtopic-post')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label style="margin: 0 5px;" >{{$topicDetail->topic_name}}</label>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"  type="hidden" value="{{$topicId}}" name="hdnTopicId" id="hdnTopicId" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control"  type="text" placeholder="Add Subtopic" name="txtSubtopicName" id="txtSubtopicName" >
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control"  placeholder="Add Description" name="txtSubtopicDesc" id="txtSubtopicDesc" row="3" ></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Add Subtopic</button>
                                </div>
                            </form>
                        @include('layouts.errors')
                        @else
                            <p>&nbsp;</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="starter-template">
    <div class="col-md-10 col-md-offset-1">



    </div>
    </div>


@endsection