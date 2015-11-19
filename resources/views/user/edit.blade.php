@extends('layout')

@section('title')
    Modification de {{ $user }}
@stop

@section('content')
    <div class="row">
        <div class="col-md-push-4 col-md-4">
            <p class="text-center">

                @if($user->avatar)
                    <img src="{{ url($user->avatar) }}"
                         class="img-circle" alt="logo" width="200" height="200"/>
                @else
                    <img src="{{ asset('img/anonymous.png') }}"
                         class="img-circle" alt="logo" width="200" height="200"/>
                @endif
            </p>
        </div>
    </div>

    <br>
    @include('user.form')
@stop