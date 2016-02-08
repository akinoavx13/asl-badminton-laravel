@extends('emails.layout')

@section('title')
    Nouvelle inscription
@stop

@section('content')
    <p>Bonjour {{ $forname }} {{ $name }}</p>
    <br>

    <p>
        Nous venons de créer votre compte sur le site <a href="http://badminton.aslectra.com/">Badminton AS Lectra</a>.
    </p>
    <p>
        Pour terminer la création de votre compte, merci de <a href="{{ route('user.get_first_connection', [$id, $token_first_connection]) }}">fournir quelques informations</a>.
    </p>
@stop