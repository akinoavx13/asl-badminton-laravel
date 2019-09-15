@extends('layout')

@section('title')
    Accueil
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h1 class="text-center">
                        Gestion du set de la section 
                        @if($auth->hasRole('admin'))
                            <a href="{{ route('volunteer.index') }}" class="text-primary">
                                 <span class="fa fa-newspaper-o"></span></a>
                            <a href="{{ route('volunteer.check') }}" class"="text-muted">(mail alert)</a>
                        @endif
                    </h1>
                </div>
                <div class="panel-body">
                    

                    <div class="col-md-4">
                        <p class="text-center">Séance précédente ({{$yesterday}})</p>
                        <div class="text-center">
                                @if (count($volunteerYesterday) ==0)
                                <button type="button" class="btn btn-danger btn-outline dim" onclick="">
                                    Personne !!!
                                </button>
                            @else
                                    <h3 class="text-center">{{$volunteerYesterday[0]->user->forname}} {{$volunteerYesterday[0]->user->name}}</h3>
                            @endif
                            
                        </div>
                    </div>

                    <div class="col-md-4">
                        <p class="text-center">Séance du jour ({{ $today}})</p>
                        <div class="text-center">
                            @if ($openToday == true)
                                @if (count($volunteerToday) ==0)
                                    <button type="button" class="btn btn-danger btn-outline dim" data-toggle="modal" data-target=".volunteerToday">
                                        Je m’occupe du set !
                                    </button>
                                @else
                                     @if($auth->id == $volunteerToday[0]->user_id)
                                        <h3 class="text-center">{{$volunteerToday[0]->user->forname}} {{$volunteerToday[0]->user->name}} 
                                        <a href="{{ route('volunteer.delete', $volunteerToday[0]->id) }}" class="text-danger"><span
                                                class="fa fa-times"></span></a></h3>
                                    @else
                                        <h3 class="text-center">{{$volunteerToday[0]->user->forname}} {{$volunteerToday[0]->user->name}} </h3>
                                    @endif
                                @endif
                            @else
                                Pas de séance aujourd'hui
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <p class="text-center">Prochaine séance ({{$tomorrow}})</p>
                                @if (count($volunteerTomorrow) ==0)
                                <button type="button" class="btn btn-danger btn-outline dim" data-toggle="modal" data-target=".volunteerTomorrow">
                                    Je m’occupe du set !
                                </button>
                            @else
                                 @if($auth->id == $volunteerTomorrow[0]->user_id)
                                    <h3 class="text-center">{{$volunteerTomorrow[0]->user->forname}} {{$volunteerTomorrow[0]->user->name}}
                                    <a href="{{ route('volunteer.delete', $volunteerTomorrow[0]->id) }}" class="text-danger"><span
                                            class="fa fa-times"></span></a></h3>
                                @else
                                    <h3 class="text-center">{{$volunteerTomorrow[0]->user->forname}} {{$volunteerTomorrow[0]->user->name}}</h3> 
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade volunteerToday" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
                    <h2 class="modal-title text-center">Je m’occupe du set</h2>
                </div>

                <div class="modal-body">

                    {!! Form::open(['route' => 'volunteer.create', 'class' => 'form-horizontal']) !!}

                    <p class="text-left">Je suis volontaire pour apporter ma contribution à la section badminton. 
                    <strong class='text-danger'>Cela implique que je m’engage à :</strong>
                    <ol>
                        <li>Prendre le set de badminton à la R&D SW</li>
                        <li>Etre au plus tard à 12h à la salle</li>
                        <li>Fermer le casier des poteaux en fin de séance</li>
                        <li>Vérifier que les volants sont tous rangés dans le bon sens dans les tubes</li>
                        <li>M'assurer que tout le monde quitte les vestiaires à 13h10 au plus tard</li>
                        <li>Ramener le set complet au plus tard à 14h à la R&D SW</li>
                    </ol>
                    <p class="text-muted text-center">Note : Il est possible d'annuler depuis le site en cas de changement d'avis ou problème d'agenda</p>
                    <div class="form-group text-center">
                        {!! Form::hidden('dateresp', 'today', ['class' => 'form-control', 'required']) !!}
                        {!! Form::submit("Je suis d’accord pour respecter ces engagements", ['class' => 'btn btn-danger']) !!}
                    </div>

                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </div>
    <div class="modal fade volunteerTomorrow" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="fa fa-times"></span>
                        </button>
                        <h2 class="modal-title text-center">Je m’occupe du set </h2>
                    </div>

                    <div class="modal-body">

                        {!! Form::open(['route' => 'volunteer.create', 'class' => 'form-horizontal']) !!}

                        <p class="text-left">Je suis volontaire pour apporter ma contribution à la section badminton. 
                        <strong class='text-danger'>Cela implique que je m’engage à :</strong>
                        <ol>
                            <li>Prendre le set de badminton à la R&D SW</li>
                            <li>Etre au plus tard à 12h à la salle</li>
                            <li>Fermer le casier des poteaux en fin de séance</li>
                            <li>Vérifier que les volants sont tous rangés dans le bon sens dans les tubes</li>
                            <li>M'assurer que tout le monde quitte les vestiaires à 13h10 au plus tard</li>
                            <li>Ramener le set complet au plus tard à 14h à la R&D SW</li>
                        </ol>
                        <p class="text-muted text-center">Note : Il est possible d'annuler depuis le site en cas de changement d'avis ou problème d'agenda</p>
                        <div class="form-group text-center">
                            {!! Form::hidden('dateresp', 'tomorrow', ['class' => 'form-control', 'required']) !!}
                            {!! Form::submit("Je suis d’accord pour respecter ces engagements", ['class' => 'btn btn-danger']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>


    @include('actuality.create')

    <hr>

    <div class="row">
        <div class="col-md-8">
            <div class="col-md-6">
                <div class="text-center">
                        <button type="button" class="btn btn-primary btn-outline dim" onclick="">Résultats</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center">
                        <button type="button" class="btn btn-warning btn-outline dim" onclick="location.href='{{route('sportHall.index')}}'">Jeu libre</button>
                </div>
            </div>
            @if(count($scores) > 0)
                @foreach($scores as $score)
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div class="row" style="font-size: 15px;">
                                <div class="col-md-3 text-center">
                                    @if($score->hasFirstTeamWin(true))
                                        <span class="btn btn-primary">
                                            {{ $score->userOneTeamOne_forname }} {{ $score->userOneTeamOne_name }}
                                            @if($score->userTwoTeamOne_forname != null && $score->userTwoTeamOne_name != null)
                                                <br>
                                                <span style="font-weight: bold;">&</span>
                                                <br>
                                                {{ $score->userTwoTeamOne_forname }} {{ $score->userTwoTeamOne_name }}
                                            @endif
                                        </span>
                                    @else
                                        {{ $score->userOneTeamOne_forname }} {{ $score->userOneTeamOne_name }}
                                        @if($score->userTwoTeamOne_forname != null && $score->userTwoTeamOne_name != null)
                                            <br>
                                            <span style="font-weight: bold;">&</span>
                                            <br>
                                            {{ $score->userTwoTeamOne_forname }} {{ $score->userTwoTeamOne_name }}
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-3 text-center">
                                    @if($score->hasUnplayed(true))
                                        <span class="text-danger">Non joué</span>
                                    @elseif($score->hasMyWo(true) || $score->hasHisWo(true))
                                        <span class="text-danger">Forfait</span>
                                    @else
                                        {{ $score->first_set_first_team }}
                                        <span class="text-danger">/</span>
                                        {{ $score->first_set_second_team }}
                                        -
                                        {{ $score->second_set_first_team }}
                                        <span class="text-danger">/</span>
                                        {{ $score->second_set_second_team }}
                                        @if($score->third_set_first_team != 0 && $score->third_set_second_team != 0)
                                            -
                                            {{ $score->third_set_first_team }}
                                            <span class="text-danger">/</span>
                                            {{ $score->third_set_second_team }}
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-3 text-center">
                                    @if($score->hasSecondTeamWin(true))
                                        <span class="btn btn-primary">
                                            {{ $score->userOneTeamTwo_forname }} {{ $score->userOneTeamTwo_name }}
                                            @if($score->userTwoTeamTwo_forname != null && $score->userTwoTeamTwo_name != null)
                                                <br>
                                                <span style="font-weight: bold;">&</span>
                                                <br>
                                                {{ $score->userTwoTeamTwo_forname }} {{ $score->userTwoTeamTwo_name }}
                                            @endif
                                        </span>
                                    @else
                                        {{ $score->userOneTeamTwo_forname }} {{ $score->userOneTeamTwo_name }}
                                        @if($score->userTwoTeamTwo_forname != null && $score->userTwoTeamTwo_name != null)
                                            <br>
                                            <span style="font-weight: bold;">&</span>
                                            <br>
                                            {{ $score->userTwoTeamTwo_forname }} {{ $score->userTwoTeamTwo_name }}
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-3 text-center text-navy">
                                    {{ ucfirst(Jenssegers\Date\Date::create($score->updated_at->year, $score->updated_at->month, $score->updated_at->day, $score->updated_at->hour, $score->updated_at->minute, $score->updated_at->second)->ago()) }}
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <hr>
                            @include('post.indexScore')
                            @include('post.createScore')
                        </div>
                    </div>
                @endforeach

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            {!! $scores->render() !!}
                        </div>
                    </div>
                </div>

            @else
                <h2 class="text-center text-danger">
                    Pas encore de match
                </h2>
            @endif
        </div>

        <div class="col-md-4">
                <div class="text-center">
                    <button type="button" class="btn btn-primary btn-outline dim" data-toggle="modal"
                            data-target=".actuality">Poster une actualité
                    </button>
                </div>
            
            @include('actuality.index')
        </div>
    </div>
@stop