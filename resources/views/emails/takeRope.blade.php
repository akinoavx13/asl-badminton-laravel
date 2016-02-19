@extends('emails.layout')

@section('title')
    Demande de cordage
@stop

@section('content')
    <p>Bonjour, </p>
    <br>

    <p>
        Nous vous informons que {{ $forname }} {{ $name }} passera prochainement pour un cordage à prendre sur la bobine de l'AS Lectra Badminton.
    </p>

@stop