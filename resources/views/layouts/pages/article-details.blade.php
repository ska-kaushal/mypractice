@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if(!is_null($articleDetail))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>
                                Article Details
                                <span class="pull-right">
                                <a href='{{route('article-list',[$subtopicId])}}' class="btn btn-xs btn-primary">
                                   Back
                                </a>
                            </span>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="list-group">
                                <div class="list-group-item list-group-item">
                                    <h4 class="list-group-item-heading">{{$articleDetail->article_name}}</h4>
                                    <p class="list-group-item-text ">{{$articleDetail->article_description}}</p>
                                </div>
                            </div>

                            <div class="list-group">
                                @if(!$examples->isEmpty())

                                    <div class="list-group">
                                        @foreach($examples as $example)
                                            @if($articleDetail->created_by == $example->created_by)
                                                <div class="list-group-item list-group-item">
                                                    <h5 class="list-group-item-heading">
                                                        {{$example->example}}
                                                    </h5>
                                                </div>
                                            @endif

                                        @endforeach
                                    </div>
                                    @if ($examples->hasMorePages())
                                        <div class="list-group-item text-center" href="#">{{ $examples->links() }}</div>
                                    @endif
                                @else
                                    <div class="list-group-item text-center" href="#">No Example is found</div>
                                @endif
                            </div>
                            <div class="list-group">

                                @if(!$userExamples->isEmpty())

                                    <div class="list-group">
                                        @foreach($userExamples as $userExample)
                                            @if($userExample->is_approved == 1)
                                                <div class="list-group-item list-group-item-success">
                                                    <h5 class="list-group-item-heading">
                                                        {{$userExample->example}}
                                                        @if($articleDetail->created_by == auth()->id())
                                                            <div class="btn-group btn-group-xs pull-right" role="group"
                                                                 aria-label="...">
                                                                <a href="javascript:void(0)"
                                                                   id="{{$userExample->user_example_id}}"
                                                                   onclick='exampleReview(this,2);' type="button"
                                                                   class="btn btn-danger">Reject</a>
                                                            </div>
                                                        @endif
                                                    </h5>
                                                    <p class="pull_left text-left creted-by-txt list-group-item-text">
                                                        <small>~ {{$userExample->users->name}}</small>
                                                    </p>
                                                </div>
                                            @elseif($userExample->is_approved == 2)
                                                <div class="list-group-item list-group-item-danger">
                                                    <h5 class="list-group-item-heading">
                                                        {{$userExample->example}}
                                                        @if($articleDetail->created_by == auth()->id())
                                                            <div class="btn-group btn-group-xs pull-right" role="group"
                                                                 aria-label="...">
                                                                <a href="javascript:void(0)"
                                                                   id="{{$userExample->user_example_id}}"
                                                                   onclick='exampleReview(this,1);' type="button"
                                                                   class="btn btn-success">Approve</a>
                                                            </div>
                                                        @endif
                                                    </h5>
                                                    <p class="pull_left text-left creted-by-txt list-group-item-text">
                                                        <small>~ {{$userExample->users->name}}</small>
                                                    </p>
                                                </div>
                                            @else
                                                <div class="list-group-item list-group-item-warning">
                                                    <div class="list-group-item-heading row">
                                                        <div class="col-8">
                                                            {{$userExample->example}}
                                                        </div>
                                                        <div class="col-4">
                                                            @if($articleDetail->created_by == auth()->id())
                                                                <div class="btn-group btn-group-xs pull-right"
                                                                     role="group" aria-label="...">
                                                                    <a href="javascript:void(0)"
                                                                       id="{{$userExample->user_example_id}}"
                                                                       onclick='exampleReview(this,1);' type="button"
                                                                       class="btn btn-success">Approve</a>
                                                                    <a href="javascript:void(0)"
                                                                       id="{{$userExample->user_example_id}}"
                                                                       onclick='exampleReview(this,2);' type="button"
                                                                       class="btn btn-danger">Reject</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p class="pull_left text-left creted-by-txt list-group-item-text">
                                                        <small>~ {{$userExample->users->name}}</small>
                                                    </p>
                                                </div>
                                            @endif

                                        @endforeach
                                    </div>
                                    @if ($userExamples->hasMorePages())
                                        <div class="list-group-item text-center"
                                             href="#">{{ $userExamples->links() }}</div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="panel-footer">
                            <form name="frmAddArticle" action="{{route('example-post')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="hdnArticleId" id="hdnArticleId"
                                           value="{{$articleDetail->article_id}}">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="hdnSubtopicId" id="hdnSubtopicId"
                                           value="{{$articleDetail->subtopic_id}}">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="hdnTopicId" id="hdnTopicId"
                                           value="{{$articleDetail->topic_id}}">
                                </div>
                                <div class="form-group row">
                                    <div class="col-10 no_margin">
                                        <input class="form-control" placeholder="Add Your Example" name="txtExample"
                                               id="txtExample">
                                    </div>
                                    <div class="col-2 no_margin">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <br/><br/>
                                </div>
                            </form>

                            @include('layouts.errors')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection