@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="list-group">
                        <a class="list-group-item list-group-item-heading" href="{{route('topic-list')}}">
                            My Practices
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
