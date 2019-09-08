@extends('emails.layout')

@section('title')
    Demande de cordage
@stop

@section('content')
    <p>Bonjour, </p>
    <br>

    <p>
        Nous vous informons que {{ $forname }} {{ $name }} passera prochainement pour un cordage à prendre sur la bobine de l'AS Lectra Badminton.<br>
        La tension demandée pour le cordage est de <strong>  {{ $tension }} </strong>kg<br>
        @if ($comment != "")
        	Le joueur souhaite porter à votre connaissance le commentaire suivant:<br>
        	<strong>{{ $comment }}</strong>
        @endif
    </p>

@stop