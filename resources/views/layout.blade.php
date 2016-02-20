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

<body class="md-skin fixed-sidebar">

    <div id="wrapper">
        @include('navbar.navbar')
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                @include('navbar.navbar-top')
            </div>
            @include('flash.flash-session')
            <div class="wrapper wrapper-content animated fadeInRight">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.min.js') }}"></script>

    @yield('javascript')
    @include('flash.flash-alert')

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-74085021-1', 'auto');
        ga('send', 'pageview');

    </script>

</body>

</html>