<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>

<h1 class="text-center">
    AS Lectra Badminton
</h1>

<hr>

<h3 class="text-center">
    @yield('title')
</h3>

@yield('content')

<br>
<p>Cordialement, </p>

<p>L'AS Lectra Badminton</p>
</body>

</html>