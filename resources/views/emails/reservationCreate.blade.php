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
        Un fichier ".ics" vous est fourni pour prévenir vos partenaires.
    </p>
@stop