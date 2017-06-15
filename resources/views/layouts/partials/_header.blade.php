<div class="container form-group">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            @if(session()->has('message'))
                <div class="hideMessage alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @elseif(session()->has('error'))
                <div class="hideMessage alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif

            <div class="btn-group btn-breadcrumb">
                <a href="/home" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                @if(isset($topicDetail))
                    @if($topicDetail->created_by == auth()->id())
                        <a href="{{route('topic-list')}}" class="btn btn-default">{{$topicDetail->topic_name}}</a>
                    @else
                        <a href="{{route('browse-topic-list')}}" class="btn btn-default">{{$topicDetail->topic_name}}</a>
                    @endif
                @endif
                @if(isset($subtopicDetail))
                    <a href="{{route('subtopic-list',[$subtopicDetail->topic_id])}}" class="btn btn-default">{{$subtopicDetail->subtopic_name}}</a>
                @endif
                @if(isset($articleDetail))
                    <a href="{{route('article-list',[$articleDetail->subtopic_id])}}" class="btn btn-default">{{$articleDetail->article_name}}</a>
                @endif
            </div>

        </div>
    </div>
</div>