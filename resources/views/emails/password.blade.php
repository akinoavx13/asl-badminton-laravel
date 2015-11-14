@extends('emails.email-layout')

@section('content')
    <p>
        Voici le lien de réinitialisation du mot de passe : <a href="{{ url('password/reset/'.$token) }}">Réninitialiser
            votre mot de passe</a>
    </p>
@stop