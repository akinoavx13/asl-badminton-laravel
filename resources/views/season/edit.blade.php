@extends('layout')

@section('title')
    Modification de {{ $season }}
@stop

@section('content')
    @include('season.form')
@stop