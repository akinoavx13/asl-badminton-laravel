@extends('emails.layout')

@section('title')
    Email au développeur
@stop

@section('content')
    <p>Bonjour {{ $dev }},</p>
    <br>

    <p>Vous avez reçu un message de {{ $sender }} ({{ $email }}) : </p>

    <p>{!! $content !!}</p>
@stop