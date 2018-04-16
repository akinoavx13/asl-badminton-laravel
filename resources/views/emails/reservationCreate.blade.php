@extends('emails.layout')

@section('title')
    Nouvelle réservation
@stop

@section('content')
    <p>Bonjour {{ $forname }} {{ $name }},</p>
    <br>

    <p>
        Nous vous informons que la réservation a bien été créée.
    </p>
    <p>
        Un fichier ".ics" est en attachement pour vous permettre d'envoyer un rendez vous à vos adversaires.<br>
        Il faut ouvrir la pièce jointe puis cliquer sur envoyer.

    </p>
@stop