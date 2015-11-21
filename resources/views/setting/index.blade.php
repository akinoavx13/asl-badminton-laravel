@extends('layout')

@section('title')
    Paramètres
@stop

@section('content')

    <h1 class="text-center">Paramètres</h1>
    <hr>

    @if($setting === null)
        <div class="text-center">
            <a href="{{ route('setting.store') }}" class="btn btn-primary">Créer la page paramètre</a>
        </div>
    @else
        @include('setting.form')
    @endif

@stop