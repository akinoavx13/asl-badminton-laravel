@extends('layout')

@section('title')
    Réservations
@stop

@section('content')

    @foreach($courts as $court)
        {{ $court }}
    @endforeach

@stop