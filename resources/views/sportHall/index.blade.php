@extends('layout')

@section('title')
    Personnes présentes pour du jeu libre
@stop

@section('content')

    <h1 class="text-center">Personnes présentes pour du jeu libre</h1>

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">
                Les plus assidus :
            </h2>
            <div class="row">

            </div>
            @foreach($mostPresentPeoples as $index => $people)
                @if($index == 0)
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <div class="text-center">
                                        <span class="fa fa-trophy fa-2x"></span>
                                        {{ $people->user->forname }} {{ $people->user->name }} : {{ $people->count }} fois
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($index == 1)
                    <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="text-center">
                                    N°2 {{ $people->user->forname }} {{ $people->user->name }} : {{ $people->count }} fois
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($index == 2)
                    <div class="col-md-offset-4 col-md-4">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="text-center">
                                    N°3 {{ $people->user->forname }} {{ $people->user->name }} : {{ $people->count }} fois
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h1 class="text-center">
                        Hier
                    </h1>
                </div>
                <div class="panel-body">
                    @foreach($presentPeopleYesterday as $yesterday)
                        <p class="text-center">
                            @if($auth->id == $yesterday->user->id)
                                {{ $yesterday->user->forname }} {{ $yesterday->user->name }}
                            @else
                                {{ $yesterday->user->forname }} {{ $yesterday->user->name }}
                                <a href="mailto:{{ $yesterday->user->email }}"><span class="fa fa-paper-plane"></span></a>
                            @endif
                        </p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h1 class="text-center">
                        Aujourd'hui
                    </h1>
                </div>
                <div class="panel-body">

                    <div class="text-center">
                        <a href="{{ route('sportHall.create', ['today', $auth->id]) }}" class="btn btn-primary">Y aller !</a>
                    </div>

                    <hr>

                    @foreach($presentPeopleToday as $today)
                        <p class="text-center">
                            @if($auth->id == $today->user->id)
                                {{ $today->user->forname }} {{ $today->user->name }}
                                <a href="{{ route('sportHall.delete', $today->id) }}" class="text-danger"><span
                                            class="fa fa-times"></span></a>
                            @else
                                {{ $today->user->forname }} {{ $today->user->name }}
                                <a href="mailto:{{ $today->user->email }}"><span class="fa fa-paper-plane"></span></a>
                            @endif
                        </p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h1 class="text-center">
                        Demain
                    </h1>
                </div>
                <div class="panel-body">

                    <div class="text-center">
                        <a href="{{ route('sportHall.create', ['tomorrow', $auth->id]) }}" class="btn btn-primary">Y aller !</a>
                    </div>

                    <hr>

                    @foreach($presentPeopleTomorrow as $tomorrow)
                        <p class="text-center">
                            @if($auth->id == $tomorrow->user->id)
                                {{ $tomorrow->user->forname }} {{ $tomorrow->user->name }}
                                <a href="{{ route('sportHall.delete', $tomorrow->id) }}" class="text-danger"><span
                                            class="fa fa-times"></span></a>
                            @else
                                {{ $tomorrow->user->forname }} {{ $tomorrow->user->name }}
                                <a href="mailto:{{ $tomorrow->user->email }}"><span class="fa fa-paper-plane"></span></a>
                            @endif
                        </p>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@stop