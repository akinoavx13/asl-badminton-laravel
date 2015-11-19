@extends('layout')

@section('title')
    Modification de {{ $user }}
@stop

@section('content')
    @include('users.form')
@stop