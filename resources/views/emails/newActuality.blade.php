@extends('emails.layout')

@section('content')
    <p>Bonjour,</p>
    <br>

    <p>Une nouvelle actualité vient d'être écrite par {{ $writter }}. Merci de ne pas répondre à ce mail mais
        directement sur <a href="http://badminton.aslectra.com/home">AS Lectra badminton</a> !</p>

    <hr>
    
    <h2 class="text-danger">
        {{ $title }}
    </h2>

    <p class="text-left">
        {!! $content !!}
    </p>

@stop