<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AS Lectra Badminton">
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="shortcut-icon" href="{{ asset('favicon.ico') }}" />

    <title>@yield('title')</title>

    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" media="print" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" media="screen and (min-width: 550px)" />

</head>

<body class="gray-bg">

<br>
<br>

<div class="row">
    <div class="col-md-offset-5 col-md-2">
        <img class="img-responsive" src="{{ asset('img/logo.png') }}" alt="logo"/>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-offset-3 col-md-6">

        <div class="text-center">
            <h1>Bienvenue sur le site de l'AS Lectra Badminton</h1>
            @yield('contentTitle')
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    @include('flash.flash-session')
                </div>
            </div>
        </div>

        @yield('contentBody')
    </div>
</div>


@yield('javascript')

</body>

</html>