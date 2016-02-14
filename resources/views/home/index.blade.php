@extends('layout')

@section('title')
    Accueil
@stop

@section('content')

    <h1 class="text-center">Les derniers matchs</h1>

    @include('actuality.create')
    <hr>

    <div class="row">
        <div class="col-md-8">
            @if(count($scores) > 0)
                <hr>
                @foreach($scores as $score)

                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div class="row" style="font-size: 15px;">
                                <div class="col-md-3 text-center">
                                    @if($score->hasFirstTeamWin(true))
                                        <span class="btn btn-primary">
                                            {{ $score->userOneTeamOne_forname }} {{ $score->userOneTeamOne_name }}
                                            @if($score->userTwoTeamOne_forname != null && $score->userTwoTeamOne_name != null)
                                                <span style="font-weight: bold;">&</span>
                                                <br>
                                                {{ $score->userTwoTeamOne_forname }} {{ $score->userTwoTeamOne_name }}
                                            @endif
                                        </span>
                                    @else
                                        {{ $score->userOneTeamOne_forname }} {{ $score->userOneTeamOne_name }}
                                        @if($score->userTwoTeamOne_forname != null && $score->userTwoTeamOne_name != null)
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
                                                <span style="font-weight: bold;">&</span>
                                                <br>
                                                {{ $score->userTwoTeamTwo_forname }} {{ $score->userTwoTeamTwo_name }}
                                            @endif
                                        </span>
                                    @else
                                        {{ $score->userOneTeamTwo_forname }} {{ $score->userOneTeamTwo_name }}
                                        @if($score->userTwoTeamTwo_forname != 0 && $score->userTwoTeamTwo_name != 0)
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
            @include('actuality.index')
        </div>
    </div>
@stop