@extends('layout')

@section('title')
    Création d'une inscription
@stop

@section('content')

    @if($alreadySubscribe)
        <h2 class="text-center text-danger">
            Vous êtes déjà inscrit à la saison, modifier votre inscription <a href="{{ route('player.edit', $myPlayer->id) }}">ici</a> !
        </h2>
    @else
        @include('player.form')
    @endif
@stop