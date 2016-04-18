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
                    <table class="table table-bordered table-hover display" id="userList">
                        <tbody>
                        @for($nbMatchRank1 = 0; $nbMatchRank1 < $serie['info']->number_matches_rank_1; $nbMatchRank1++)
                            <tr>
                                <td>ok</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>

                {{--@foreach($serie as $rankNumber => $matches)--}}
                {{--@if($rankNumber != 'info')--}}
                {{--<div class="col-md-2">--}}
                {{--@foreach($matches as $index => $match)--}}
                {{--<div class="panel panel-default">--}}
                {{--<div class="panel-body">--}}
                {{--<p class="text-center">--}}
                {{--@if($match['edit'])--}}
                {{--<a href="{{ route('score.editTournament', [$match['scoreId'], str_replace(' ', '-', $match['firstTeam']), str_replace(' ', '-', $match['secondTeam'])]) }}" class="text-center">--}}
                {{--{{ $match['firstTeam'] }} vs {{ $match['secondTeam'] }}--}}
                {{--</a>--}}
                {{--@else--}}
                {{--{{ $match['firstTeam'] }} vs {{ $match['secondTeam'] }}--}}
                {{--@endif--}}
                {{--<a href="{{ route('match.edit', $match['id']) }}" class="btn btn-info"><span--}}
                {{--class="fa fa-edit"></span></a>--}}
                {{--</p>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--@endforeach--}}
                {{--</div>--}}
                {{--@endif--}}
                {{--@endforeach--}}
            </div>
        </div>

    @endforeach

@stop