@extends('emails.layout')

@section('title')
    Nouvelle inscription
@stop

@section('content')
    <p>Bonjour {{ $forname }},</p>
    <br>

    <p>
        Je viens de créer ton compte sur le site <a href="http://badminton.aslectra.com/">Badminton AS Lectra</a>.
    </p>
    <p>
        Pour terminer la création de ton compte, merci de <a href="{{ route('user.get_first_connection', [$id, $token_first_connection]) }}">fournir quelques informations</a> en utilisant ce lien.
    </p>

    <p>
        Tu pourras ensuite via le site et le menu « s’inscrire à une saison » compléter ton profil et choisir ta formule de jeu.
    </p>

    <p>
        Pour rappel le descriptif complet est sur le site de <a href="http://aslectra.com">l'aslectra</a>, je suis également dispo si tu as des questions. N’hésite pas à passer me voir.
    </p>

@stop