<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Topics to learn</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ URL::asset('css/bootstrap-grid.min.css') }}" rel="stylesheet" type="text/css" >
        <!-- Custom CSS -->
        <link href="{{ URL::asset('1-col-portfolio.scss') }}" rel="stylesheet" type="text/css" >

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery -->
        <script src="{{ URL::asset('js/jquery.js') }}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    </head>
    <body>
        <!-- Page Content -->
        <div class="container">
            @include('layouts.partials._navigation')
            @include('layouts.partials._header')
            @yield('content')
            @include('layouts.partials._footer')
        </div>
    </body>
</html>