@extends('layout')

@section('title')
    Classement du tournoi
@stop

@section('content')

    <h1 class="text-center">
        Tournoi du
        <span class="font-bold">{{ $tournament->start->format('l j F Y') }}</span>
        au
        <span class="font-bold">{{ $tournament->end->format('l j F Y') }}</span>
    </h1>
    <hr>

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
                    <table class="table">
                        <tbody>

                        @for($nbMatchRank1 = 1; $nbMatchRank1 <= $serie['info']->number_matches_rank_1 * 2 - 1; $nbMatchRank1++)
                            <tr style="border: none;">
                                @for($rank = 1; $rank <= $serie['info']->number_rank; $rank++)

                                    @if($serie[$rank][$nbMatchRank1] == "vide")
                                        <td style="border: none; padding: 0;"></td>
                                    @else

                                        <td style="border: none; padding: 0 0 0 20px;">
                                            @if($serie[$rank][$nbMatchRank1]['display'] || $auth->hasRole('admin'))
                                                <span style="font-weight: bold;">
                                                    N°{{ $serie[$rank][$nbMatchRank1]['matchNumber'] }}
                                                </span>

                                                @if($serie[$rank][$nbMatchRank1]['edit'])
                                                    <span>
                                                        <a href="{{ route('score.editTournament', [$serie[$rank][$nbMatchRank1]['scoreId'], str_replace(' ', '-', $serie[$rank][$nbMatchRank1]['firstTeamName']), str_replace(' ', '-', $serie[$rank][$nbMatchRank1]['secondTeamName'])]) }}">Editer</a>
                                                    </span>
                                                @endif

                                                @if($auth->hasRole('admin'))
                                                    <span>
                                                        <a href="{{ route('match.edit', $serie[$rank][$nbMatchRank1]['id']) }}" class="text-danger">Administrer</a>
                                                    </span>
                                                @endif
                                            @endif

                                            @if($serie[$rank][$nbMatchRank1]['display'])
                                                <table class="table table-bordered {{ $serie[$rank][$nbMatchRank1]['owner'] ? 'text-white' : '' }}"
                                                       style="margin-bottom: -1px; {{ $serie[$rank][$nbMatchRank1]['score'] != null && $serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true) ? 'background: #DFF0D8;' : '' }}
                                                               {{ $serie[$rank][$nbMatchRank1]['owner'] ? 'background: #21B9BB;' : '' }}">
                                                    <tr>
                                                        <td style="padding: 3px 5px 3px 5px;">
                                                            @if($serie[$rank][$nbMatchRank1]['firstTeamName'] == "" && $serie[$rank][$nbMatchRank1]['infoLooserFirstTeam'] != null)
                                                                {{ $serie[$rank][$nbMatchRank1]['infoLooserFirstTeam'] }}
                                                            @else
                                                                {{ $serie[$rank][$nbMatchRank1]['firstTeamName'] }}
                                                            @endif
                                                        </td>
                                                        <td style="padding: 3px 5px 3px 5px; width: 20px">
                                                            @if($serie[$rank][$nbMatchRank1]['score'] != null && ($serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true) || $serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true)))
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->first_set_first_team }}
                                                            @elseif($serie[$rank][$nbMatchRank1]['firstTeamName'] != "")
                                                                Ø
                                                            @endif
                                                        </td>
                                                        <td style="padding: 3px 5px 3px 5px; width: 20px">
                                                            @if($serie[$rank][$nbMatchRank1]['score'] != null && ($serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true) || $serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true)))
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->second_set_first_team }}
                                                            @elseif($serie[$rank][$nbMatchRank1]['firstTeamName'] != "")
                                                                Ø
                                                            @endif
                                                        </td>
                                                        <td style="padding: 3px 5px 3px 5px; width: 20px">
                                                            @if($serie[$rank][$nbMatchRank1]['score'] != null && ($serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true) || $serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true)))
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->third_set_first_team }}
                                                            @elseif($serie[$rank][$nbMatchRank1]['firstTeamName'] != "")
                                                                Ø
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table class="table table-bordered {{ $serie[$rank][$nbMatchRank1]['owner'] ? 'text-white' : '' }}"
                                                       style="margin-bottom: 5px;  {{ $serie[$rank][$nbMatchRank1]['score'] != null && $serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true) ? 'background: #DFF0D8;' : '' }}
                                                       {{ $serie[$rank][$nbMatchRank1]['owner'] ? 'background: #21B9BB;' : '' }}">
                                                    <tr>
                                                        <td style="padding: 3px 5px 3px 5px;">
                                                            @if($serie[$rank][$nbMatchRank1]['secondTeamName'] == "" && $serie[$rank][$nbMatchRank1]['infoLooserSecondTeam'] != null)
                                                                {{ $serie[$rank][$nbMatchRank1]['infoLooserSecondTeam'] }}
                                                            @else
                                                                {{ $serie[$rank][$nbMatchRank1]['secondTeamName'] }}
                                                            @endif
                                                        </td>
                                                        <td style="padding: 3px 5px 3px 5px; width: 20px">
                                                            @if($serie[$rank][$nbMatchRank1]['score'] != null && ($serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true) || $serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true)))
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->first_set_second_team }}
                                                            @elseif($serie[$rank][$nbMatchRank1]['secondTeamName'] != "")
                                                                Ø
                                                            @endif
                                                        </td>
                                                        <td style="padding: 3px 5px 3px 5px; width: 20px">
                                                            @if($serie[$rank][$nbMatchRank1]['score'] != null && ($serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true) || $serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true)))
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->second_set_second_team }}
                                                            @elseif($serie[$rank][$nbMatchRank1]['secondTeamName'] != "")
                                                                Ø
                                                            @endif
                                                        </td>
                                                        <td style="padding: 3px 5px 3px 5px; width: 20px">
                                                            @if($serie[$rank][$nbMatchRank1]['score'] != null && ($serie[$rank][$nbMatchRank1]['score']->hasFirstTeamWin(true) || $serie[$rank][$nbMatchRank1]['score']->hasSecondTeamWin(true)))
                                                                {{ $serie[$rank][$nbMatchRank1]['score']->third_set_second_team }}
                                                            @elseif($serie[$rank][$nbMatchRank1]['secondTeamName'] != "")
                                                                Ø
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            @endif()
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