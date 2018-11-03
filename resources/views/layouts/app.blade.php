<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reception Application v1.2</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" media="all">
</head>
<body style="background:#ffffff;">
<div id="app">
    <nav class="navbar navbar-default navbar-static-top" style="background: rgb(252, 248, 227);">
        <div class="container" style="padding-bottom: 5px;">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}" style="margin-top: -7px">
                    <p style="color: black"><img src="{{asset("img/logo.png")}}" height="40px"> &nbsp;<strong>Reception Application v1.2</strong></p>
                </a>
            </div>
            <div class="navbar-right" style="padding-top: 7px;">
                <a href="/view/summary?month={{date('m')}}&year={{date('Y')}}" class="btn btn-link" >Summary</a>
                <a href="/view/customers/all/unresolved" class="btn btn-link" ><strong>View All Unresolved</strong></a>
                <a href="/view/customers/all/all" class="btn btn-link">View All Customers</a>
            </div>
        </div>
    </nav>

@yield('content')


</div>

<footer class="footer" style="margin-top: 20px">
    <div class="container" align="center">
        <p class="small"><kbd>AI Software&reg; &copy;{{date('Y')}}</kbd> &nbsp;<code></code></p>
    </div>
</footer>

</body>
</html>