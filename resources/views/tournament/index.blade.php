@extends('layout')

@section('title')
    Fin de la création du tournoi
@stop

@section('content')

    <div class="row" id="top">
        <div class="col-md-12 text-center">
            @foreach($series as $serie)
                <a href="#{{ $serie['info']->name }}"
                   class="btn {{ $serie['info']->category == 'S' || $serie['info']->category == 'SH' || $serie['info']->category == 'SD' ? 'btn-warning' : '' }} {{ $serie['info']->category == 'D' || $serie['info']->category == 'DH' || $serie['info']->category == 'DD' ? 'btn-info'
         : '' }} {{ $serie['info']->category == 'M' ? 'btn-danger' : '' }}">{{ $serie['info']->name }} <span
                            class="fa fa-bookmark"></span></a>
            @endforeach
        </div>
    </div>

    <br>

    @foreach($series as $serie)
        <div class="panel {{ $serie['info']->category == 'S' || $serie['info']->category == 'SH' || $serie['info']->category == 'SD' ? 'panel-warning' : '' }} {{ $serie['info']->category == 'D' || $serie['info']->category == 'DH' || $serie['info']->category == 'DD' ? 'panel-info'
         : '' }} {{ $serie['info']->category == 'M' ? 'panel-danger' : '' }}" id="{{ $serie['info']->name }}">
            <div class="panel-heading">
                <h1 class="text-center">
                    {{ $serie['info']->name }}
                    <a href="#top" class="pull-right"><span class="fa fa-caret-square-o-up"></span></a>
                </h1>
            </div>
            <div class="panel-body">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>

                        @for($nbMatchRank1 = 1; $nbMatchRank1 <= $serie['info']->number_matches_rank_1 * 2 - 1; $nbMatchRank1++)
                            <tr style="border: none">
                                @for($rank = 1; $rank <= $serie['info']->number_rank; $rank++)
                                    @if($serie[$rank][$nbMatchRank1] == "vide")
                                        <td style="border: none"></td>
                                    @else
                                        <td style="border: none">
                                            <div class="panel panel-default" style="margin-bottom: 0;">
                                                <div class="panel-body" style="padding: 10px;">
                                                    <div class="text-center">

                                                        <span>N°{{ $serie[$rank][$nbMatchRank1]['matchNumber'] }}</span>

                                                        @if($serie[$rank][$nbMatchRank1]['score'] != null)
                                                            @if($serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true))
                                                                <span class="text-navy">{{ $serie[$rank][$nbMatchRank1]['firstTeamName'] }}</span>
                                                                <span style="font-weight: bold;">&</span>
                                                                <span>{{ $serie[$rank][$nbMatchRank1]['secondTeamName'] }}</span>
                                                            @elseif($serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true))
                                                                <span>{{ $serie[$rank][$nbMatchRank1]['firstTeamName'] }}</span>
                                                                <span style="font-weight: bold;">&</span>
                                                                <span class="text-navy">{{ $serie[$rank][$nbMatchRank1]['secondTeamName'] }}</span>
                                                            @else
                                                                <span>{{ $serie[$rank][$nbMatchRank1]['firstTeamName'] }}</span>
                                                                <span style="font-weight: bold;">&</span>
                                                                <span>{{ $serie[$rank][$nbMatchRank1]['secondTeamName'] }}</span>
                                                            @endif
                                                        @else
                                                            <span>{{ $serie[$rank][$nbMatchRank1]['firstTeamName'] }}</span>
                                                            <span style="font-weight: bold;">&</span>
                                                            <span>{{ $serie[$rank][$nbMatchRank1]['secondTeamName'] }}</span>
                                                        @endif

                                                        @if($serie[$rank][$nbMatchRank1]['edit'])
                                                            <a href="{{ route('score.editTournament', [$serie[$rank][$nbMatchRank1]['scoreId'], str_replace(' ', '-', $serie[$rank][$nbMatchRank1]['firstTeamName']), str_replace(' ', '-', $serie[$rank][$nbMatchRank1]['secondTeamName'])]) }}">
                                                                Editer
                                                            </a>
                                                        @endif
                                                        @if($auth->hasRole('admin'))
                                                            <a href="{{ route('match.edit', $serie[$rank][$nbMatchRank1]['id']) }}"
                                                               class="text-danger">Admin</a>
                                                        @endif
                                                        @if($serie[$rank][$nbMatchRank1]['score'] != null && ($serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true) || $serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true)))
                                                            <p class="text-center" style="margin-bottom: 0;">
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->first_set_first_team }}
                                                                <span class="text-danger">/</span>
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->first_set_second_team }}
                                                                -
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->second_set_first_team }}
                                                                <span class="text-danger">/</span>
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->second_set_second_team }}
                                                                @if($serie[$rank][$nbMatchRank1]['score']->third_set_first_team != 0 && $serie[$rank][$nbMatchRank1]['score']->third_set_second_team != 0)
                                                                    -
                                                                    {{ $serie[$rank][$nbMatchRank1]['score']->third_set_first_team }}
                                                                    <span class="text-danger">/</span>
                                                                    {{ $serie[$rank][$nbMatchRank1]['score']->third_set_second_team }}
                                                                @endif
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endforeach

@stop