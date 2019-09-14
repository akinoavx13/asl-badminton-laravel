@extends('emails.layout')

@section('title')
    Ajout de cordage
@stop

@section('content')
    <p>Bonjour, </p>
    <br>

    <p>
        Nous vous informons que {{ $forname }} {{ $name }} vient de mettre à jour le stock en ajoutant {{ $rest }} cordage(s).<br>
        
        @if ($comment != "")
        	Commentaires : {{ $comment }}<br>
        @endif
        
        
        <br>
        A titre d'information, le stock total est de {{ $total }} cordages disponibles.
        
    </p>

@stop