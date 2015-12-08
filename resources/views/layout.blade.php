<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AS Lectra Badminton">
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="shortcut-icon" href="{{ asset('favicon.ico') }}" />

    <title>@yield('title')</title>

    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">

</head>

<body>

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

</body>

</html>