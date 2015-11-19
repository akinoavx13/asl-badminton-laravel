@extends('layout')

@section('title')
    Modification de {{ $user }}
@stop

@section('content')

    @if($auth->avatar)
        <img src="{{ url($auth->avatar) }}"
             class="img-circle" alt="logo" width="150" height="150"/>
    @else
        <img src="{{ asset('img/anonymous.png') }}"
             class="img-circle" alt="logo" width="50" height="50"/>
    @endif

    @include('users.form')
@stop