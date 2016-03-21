@extends('emails.layout')

@section('title')
    Inscription formule compétition
@stop

@section('content')
    <p>Bonjour {{ $forname }} {{ $name }},</p>
    <br>

    <p>
        Nous vous informons que votre inscription à la formule compétition à bien été enregistré.
    </p>

    <p>
        Pour finaliser votre inscription, merci de bien vouloir remplir les papiers et de les remettre le plus tôt
        possible à Christophe Mahéo.
    </p>

    <p>
        <a href="{{ asset('documents/badminton-Formulaire Certificat Medical 2015-2016.pdf') }}">Certificat médicale</a>
    </p>

    <p>
        <a href="{{ asset('documents/badminton-Formulaire demande de licence 2015-2016.pdf') }}">Demande de licence</a>
    </p>
@stop