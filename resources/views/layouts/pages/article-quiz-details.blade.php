@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if(!is_null($articleDetail))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>
                                Article Quiz Details
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

                                    @foreach($examples as $example)
                                        @if($articleDetail->created_by == $example->created_by)

                                            @if($articleDetail->created_by == auth()->id())

                                                @if($example->is_answer == 1)
                                                    <div class="list-group-item list-group-item-success quiz-option-list">
                                                        <h5 class="list-group-item-heading row ">
                                                            <label class="form-check-label col-1 text-center input"
                                                                   for="{{$example->example_id}}">
                                                                <i class="glyphicon glyphicon-ok"></i>
                                                            </label>
                                                            <label class="form-check-label input col-11"
                                                                   for="{{$example->example_id}}">
                                                                {{$example->example}}
                                                            </label>
                                                        </h5>
                                                    </div>
                                                @else
                                                    <div class="list-group-item list-group-item quiz-option-list">
                                                        <h5 class="list-group-item-heading row ">
                                                            <label class="form-check-label col-1 text-center input"
                                                                   for="{{$example->example_id}}">
                                                                <input class="form-check-input" type="radio"
                                                                       name="chk_article_{{$example->article_id}}[]"
                                                                       id="{{$example->example_id}}"
                                                                       onclick='exampleSetAnswer(this,1);'
                                                                       value="option1">
                                                            </label>
                                                            <label class="form-check-label input col-11"
                                                                   for="{{$example->example_id}}">
                                                                {{$example->example}}
                                                            </label>
                                                        </h5>
                                                    </div>
                                                @endif

                                            @else
                                                @if(count($userExamples) >0)

                                                    @if($example->example_id == $userExamples->example_id && $example->is_answer == "1")
                                                        <div class="list-group-item list-group-item-success quiz-option-list">
                                                            <h5 class="list-group-item-heading row ">
                                                                <label class="form-check-label col-1 text-center input "
                                                                       for="{{$example->example_id}}">
                                                                    <i class="glyphicon glyphicon-ok"></i>
                                                                </label>
                                                                <label class="form-check-label input col-11"
                                                                       for="{{$example->example_id}}">
                                                                    {{$example->example}}
                                                                </label>
                                                            </h5>
                                                        </div>
                                                    @elseif($example->example_id == $userExamples->example_id && $example->is_answer != "1")
                                                        <div class="list-group-item list-group-item-danger quiz-option-list">
                                                            <h5 class="list-group-item-heading row ">
                                                                <label class="form-check-label col-1 text-center input "
                                                                       for="{{$example->example_id}}">
                                                                    &nbsp;<i class="glyphicon glyphicon-remove"></i>
                                                                </label>
                                                                <label class="form-check-label input col-11"
                                                                       for="{{$example->example_id}}">
                                                                    {{$example->example}}
                                                                </label>
                                                            </h5>
                                                        </div>
                                                    @else
                                                        <div class="list-group-item list-group-item quiz-option-list">
                                                            <h5 class="list-group-item-heading row ">
                                                                <label class="form-check-label col-1 text-center input "
                                                                       for="{{$example->example_id}}">
                                                                    &nbsp;
                                                                </label>
                                                                <label class="form-check-label input col-11"
                                                                       for="{{$example->example_id}}">
                                                                    {{$example->example}}
                                                                </label>
                                                            </h5>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="list-group-item list-group-item quiz-option-list">
                                                        <h5 class="list-group-item-heading row ">
                                                            <label class="form-check-label col-1 text-center input"
                                                                   for="{{$example->example_id}}">
                                                                <input class="form-check-input" type="radio"
                                                                       name="chk_article_{{$example->article_id}}[]"
                                                                       id="{{$example->example_id}}"
                                                                       onclick='exampleGiveAnswer(this,1);'
                                                                       value="option1">
                                                            </label>
                                                            <label class="form-check-label input col-11"
                                                                   for="{{$example->example_id}}">
                                                                {{$example->example}}
                                                            </label>
                                                        </h5>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                    @if ($examples->hasMorePages())
                                        <div class="list-group-item text-center" href="#">{{ $examples->links() }}</div>
                                    @endif
                                @else
                                    <div class="list-group-item text-center" href="#">No Options are found</div>
                                @endif

                            </div>


                            @if($articleDetail->created_by == auth()->id())
                                <div class="list-group">
                                    <div class="list-group-item list-group-heading quiz-option-list">
                                        <h5>User Answers</h5>
                                    </div>
                                    @if(!$examples->isEmpty())
                                        @foreach($examples as $example)
                                            @if(count($userExamples) >0)
                                                @foreach($userExamples as $userExample)
                                                    @if($example->example_id == $userExample->example_id && $example->is_answer=='1')
                                                        <div class="list-group-item list-group-item-success quiz-option-list">
                                                            <h5 class="list-group-item-heading row ">
                                                                <label class="form-check-label col-1 text-center input "
                                                                       for="{{$example->example_id}}">
                                                                    <i class="glyphicon glyphicon-ok"></i>
                                                                </label>
                                                                <label class="form-check-label input col-9"
                                                                       for="{{$example->example_id}}">
                                                                    {{$example->example}}
                                                                </label>
                                                                <label class="form-check-label input col-2"
                                                                       for="{{$example->example_id}}">
                                                                    <p class="pull-right">
                                                                        <small> ~ {{$userExample->users->name}}</small>
                                                                    </p>
                                                                </label>
                                                            </h5>
                                                        </div>
                                                    @elseif($example->example_id == $userExample->example_id && $example->is_answer!='1')
                                                        <div class="list-group-item list-group-item-danger quiz-option-list">
                                                            <h5 class="list-group-item-heading row ">
                                                                <label class="form-check-label col-1 text-center input "
                                                                       for="{{$example->example_id}}">
                                                                    <i class="glyphicon glyphicon-remove"></i>
                                                                </label>
                                                                <label class="form-check-label input col-9"
                                                                       for="{{$example->example_id}}">
                                                                    {{$example->example}}
                                                                </label>
                                                                <label class="form-check-label input col-2"
                                                                       for="{{$example->example_id}}">
                                                                    <p class="pull-right">
                                                                        <small> ~ {{$userExample->users->name}}</small>
                                                                    </p>
                                                                </label>
                                                            </h5>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if ($userExamples->hasMorePages())
                                                    <div class="list-group-item text-center"
                                                         href="#">{{ $userExamples->links() }}</div>
                                                @endif
                                            @else
                                                <div class="list-group-item text-center" href="#">No User Answers are
                                                    found
                                                </div>
                                            @endif

                                        @endforeach
                                        @if ($examples->hasMorePages())
                                            <div class="list-group-item text-center"
                                                 href="#">{{ $examples->links() }}</div>
                                        @endif
                                    @else
                                        <div class="list-group-item text-center" href="#">No Options are found</div>
                                    @endif
                                    @endif
                                </div>
                        </div>
                        <div class="panel-footer">
                            @if($articleDetail->created_by == auth()->id())
                                <form name="frmAddArticle" action="{{route('example-option-post')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input class="form-control" type="hidden" name="hdnArticleId" id="hdnArticleId"
                                               value="{{$articleDetail->article_id}}">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="hidden" name="hdnSubtopicId"
                                               id="hdnSubtopicId" value="{{$articleDetail->subtopic_id}}">
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
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection