@extends('layout')

@section('title')
    Modification du joueur {{ $player }}
@stop

@section('content')
    @include('player.form')
@stop