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
        Tu pourras ensuite via le site et le menu « s’inscrire à une saison » compléter ton profil et choisir ta formule de jeu (loisir, fun, performance etc...) ainsi que les séries (simple, double et mixte). Pour information en double et mixte les partenaires actuellement en recherche sont affichés. Si tu te mets en recherche d'autres joueurs pourrons par la suite te choisir comme partenaire.
    </p>

    <p>
        Pour rappel le descriptif complet est sur le site de <a href="http://aslectra.com">l'aslectra</a>, je suis également dispo si tu as des questions. N’hésite pas à passer me voir.
    </p>

@stop