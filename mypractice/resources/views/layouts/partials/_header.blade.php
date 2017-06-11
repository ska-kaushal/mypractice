<div class="container form-group">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="btn-group btn-breadcrumb">
                <a href="/home" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
                @if(isset($topicDetail))
                    <a href="{{route('topic-list')}}" class="btn btn-default">{{$topicDetail->topic_name}}</a>
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