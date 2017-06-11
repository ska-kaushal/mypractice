@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            Articles
                            <span class="pull-right">
                                <a href='{{route('subtopic-list',[$topicId])}}' class="btn btn-xs btn-primary">
                                   Back
                                </a>
                            </span>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            @if(!$articles->isEmpty())
                                @foreach($articles as $article)
                                    <a class="list-group-item list-group-item" href="{{route('example-list',[$article->article_id])}}">
                                        <h4 class="list-group-item-heading">{{$article->article_name}}</h4>
                                        <p class="list-group-item-text">{{$article->article_description}}</p>
                                    </a>
                                @endforeach

                                @if ($articles->hasMorePages())
                                    <div class="list-group-item text-center" href="#">{{ $articles->links() }}</div>
                                @endif
                            @else
                                <div class="list-group-item text-center" href="#">No Articles Found</div>
                            @endif
                        </div>
                    </div>
                    <div class="panel-footer">
                        @if($topicDetail->created_by == auth()->id())
                            <form name="frmAddArticle" action="{{route('article-post')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label style="margin: 0 5px;" >{{$topicDetail->topic_name}}</label>
                                </div>
                                <div class="form-group">
                                    <label style="margin: 0 5px;" >{{$subtopicDetail->subtopic_name}}</label>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"  type="hidden" value="{{$topicId}}" name="hdnTopicId" id="hdnTopicId" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control"  type="hidden" value="{{$subtopicId}}" name="hdnSubtopicId" id="hdnSubtopicId" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control"  type="text" placeholder="Add Article" name="txtArticleName" id="txtArticleName" >
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control"  placeholder="Add Description" name="txtArticleDesc" id="txtArticleDesc" row="5" ></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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

@endsection