@extends('emails.layout')

@section('title')
    Nouvelle actualité
@stop

@section('content')
    <p>Bonjour {{ $forname }} {{ $name }},</p>
    <br>

    <p>Une nouvelle actualité vient d'être écrite sur <a href="http://badminton.aslectra.com/home">AS Lectra
            badminton</a> par {{ $writter }} !</p>

    <p>Actualité : </p>

    <h2 class="text-center">
        {{ $title }}
    </h2>

    <p class="text-center">
        {!! $content !!}
    </p>
@stop