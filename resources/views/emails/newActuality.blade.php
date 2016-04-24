@extends('emails.layout')

@section('title')
    Nouvelle actualité
@stop

@section('content')
    <p>Bonjour,</p>
    <br>

    <p>Une nouvelle actualité vient d'être écrite par {{ $writter }}. Merci de ne pas répondre à ce mail mais
        directement sur <a href="http://badminton.aslectra.com/home">AS Lectra badminton</a> !</p>

    <p>Actualité : </p>

    <h2 class="text-center">
        {{ $title }}
    </h2>

    <p class="text-center">
        {!! $content !!}
    </p>

@stop