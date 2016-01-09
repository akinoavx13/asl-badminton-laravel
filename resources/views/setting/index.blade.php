@extends('layout')

@section('title')
    Paramètre global
@stop

@section('content')

    <h1 class="text-center">Paramètre global</h1>
    <hr>

    @if($setting === null)
        <div class="text-center">
            <a href="{{ route('setting.store') }}" class="btn btn-primary">Créer la page paramètre</a>
        </div>
    @else
        <div class="row">
            <div class="col-md-push-1 col-md-10">
                @include('setting.form')
            </div>
        </div>
    @endif

@stop