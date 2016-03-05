@extends('layout')

@section('title')
    Championnat en cours
@stop

@section('content')
    @if(count($championships) > 0)

        <h1 class="text-center">Choisir un championnat</h1>

        {!! Form::open(['route' => 'championship.index', 'class' => 'form-horizontal']) !!}

        <div class="form-group">
            <div class="col-md-offset-4 col-md-4">
                {!! Form::select('period_id', $championships, $championship != null && $championship->exists ? $championship->id : old('period_id'),['class' => 'form-control chosen-select', 'required']) !!}
            </div>
        </div>

        <div class="form-group text-center">
            {!! Form::submit('Voir', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
        <hr>
    @endif



    @if($championship != null)
        <h1 class="text-center">
            Championnat du
            <span class="font-bold">{{ $championship->start->format('l j F Y') }}</span>
            au
            <span class="font-bold">{{ $championship->end->format('l j F Y') }}</span>
        </h1>

        <hr>
        @if($championship->hasChampionshipSimpleWoman(true))
            @foreach(['man', 'woman'] as $gender)
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h1 class="text-center">Championnat de simple {{ $gender == 'man' ? 'homme' : 'femme'  }}</h1>
                    </div>
                    <div class="panel-body">
                        @foreach($teams['simple'][$gender] as $pool_number => $pools)
                            <h4>Poule
                                <button class="btn btn-warning btn-circle">{{ $pool_number }}</button>
                                <div style="float: right;">
                                    <a href="{{ route('championshipResult.show', [$pools['pool_id'], $championship->id]) }}" class="btn btn-primary btn-rounded">Résultats
                                        <span class="fa fa-area-chart"></span>
                                    </a>
                                </div>
                            </h4>
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">Rang</th>
                                    <th class="text-center">Points</th>
                                    <th class="text-center">Joueur</th>
                                    <th class="text-center">Matchs</th>
                                    <th class="text-center">Gagné</th>
                                    <th class="text-center">Perdu</th>
                                    <th class="text-center">Non joué</th>
                                    <th class="text-center">Gagné par forfait</th>
                                    <th class="text-center">Perdu par forfait</th>
                                    <th class="text-center">∆ Set</th>
                                    <th class="text-center">∆ Points</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pools as $index => $simpleTeam)
                                    @if($index !== 'pool_id')
                                        <tr class="text-center {{ $simpleTeam['user_id'] == $auth->id ? 'text-danger' : ''}}">
                                            <td>{{ $simpleTeam['rank'] }}</td>
                                            <td>{{ $simpleTeam['points'] }}</td>
                                            <td>{{ $simpleTeam['name'] }}</td>
                                            <td>
                                                <span class="pie">{{ $simpleTeam['matchs'] }}</span>
                                            </td>
                                            <td>{{ $simpleTeam['match_won'] }}</td>
                                            <td>{{ $simpleTeam['match_lost'] }}</td>
                                            <td>{{ $simpleTeam['match_unplayed'] }}</td>
                                            <td>{{ $simpleTeam['match_won_by_wo'] }}</td>
                                            <td>{{ $simpleTeam['match_lost_by_wo'] }}</td>
                                            <td>{{ $simpleTeam['total_difference_set'] }}</td>
                                            <td>{{ $simpleTeam['total_difference_points'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h1 class="text-center">Championnat de simple</h1>
                </div>
                <div class="panel-body">
                    @foreach($teams['simple'] as $pool_number => $pools)
                        <h4>Poule
                            <button class="btn btn-warning btn-circle">{{ $pool_number }}</button>
                            <div style="float: right;">
                                <a href="{{ route('championshipResult.show', [$pools['pool_id'], $championship->id]) }}" class="btn btn-primary btn-rounded">Résultats
                                    <span class="fa fa-area-chart"></span>
                                </a>
                            </div>
                        </h4>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Rang</th>
                                <th class="text-center">Points</th>
                                <th class="text-center">Joueur</th>
                                <th class="text-center">Matchs</th>
                                <th class="text-center">Gagné</th>
                                <th class="text-center">Perdu</th>
                                <th class="text-center">Non joué</th>
                                <th class="text-center">Gagné par forfait</th>
                                <th class="text-center">Perdu par forfait</th>
                                <th class="text-center">∆ Set</th>
                                <th class="text-center">∆ Points</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pools as $index => $simpleTeam)
                                @if($index !== 'pool_id')
                                    <tr class="text-center {{ $simpleTeam['user_id'] == $auth->id ? 'text-danger' : ''}}">
                                        <td>{{ $simpleTeam['rank'] }}</td>
                                        <td>{{ $simpleTeam['points'] }}</td>
                                        <td>{{ $simpleTeam['name'] }}</td>
                                        <td>
                                            <span class="pie">{{ $simpleTeam['matchs'] }}</span>
                                        </td>
                                        <td>{{ $simpleTeam['match_won'] }}</td>
                                        <td>{{ $simpleTeam['match_lost'] }}</td>
                                        <td>{{ $simpleTeam['match_unplayed'] }}</td>
                                        <td>{{ $simpleTeam['match_won_by_wo'] }}</td>
                                        <td>{{ $simpleTeam['match_lost_by_wo'] }}</td>
                                        <td>{{ $simpleTeam['total_difference_set'] }}</td>
                                        <td>{{ $simpleTeam['total_difference_points'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        @endif

        @if($championship->hasChampionshipDoubleWoman(true))
            @foreach(['man', 'woman'] as $gender)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="text-center">Championnat de double {{ $gender == 'man' ? 'homme' : 'femme' }}</h1>
                    </div>
                    <div class="panel-body">
                        @foreach($teams['double'][$gender] as $pool_number => $pools)
                            <h4>Poule
                                <button class="btn btn-info btn-circle">{{ $pool_number }}</button>
                                <div style="float: right;">
                                    <a href="{{ route('championshipResult.show', [$pools['pool_id'], $championship->id]) }}" class="btn btn-primary btn-rounded">Résultats
                                        <span class="fa fa-area-chart"></span>
                                    </a>
                                </div>
                            </h4>
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">Rang</th>
                                    <th class="text-center">Points</th>
                                    <th class="text-center">Joueur</th>
                                    <th class="text-center">Matchs</th>
                                    <th class="text-center">Gagné</th>
                                    <th class="text-center">Perdu</th>
                                    <th class="text-center">Non joué</th>
                                    <th class="text-center">Gagné par forfait</th>
                                    <th class="text-center">Perdu par forfait</th>
                                    <th class="text-center">∆ Set</th>
                                    <th class="text-center">∆ Points</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pools as $index => $doubleTeam)
                                    @if($index !== 'pool_id')
                                        <tr class="text-center {{ $doubleTeam['userOne_id'] == $auth->id || $doubleTeam['userTwo_id'] == $auth->id ? 'text-danger' : ''}}">
                                            <td>{{ $doubleTeam['rank'] }}</td>
                                            <td>{{ $doubleTeam['points'] }}</td>
                                            <td>{{ $doubleTeam['name'] }}</td>
                                            <td>
                                                <span class="pie">{{ $doubleTeam['matchs'] }}</span>
                                            </td>
                                            <td>{{ $doubleTeam['match_won'] }}</td>
                                            <td>{{ $doubleTeam['match_lost'] }}</td>
                                            <td>{{ $doubleTeam['match_unplayed'] }}</td>
                                            <td>{{ $doubleTeam['match_won_by_wo'] }}</td>
                                            <td>{{ $doubleTeam['match_lost_by_wo'] }}</td>
                                            <td>{{ $doubleTeam['total_difference_set'] }}</td>
                                            <td>{{ $doubleTeam['total_difference_points'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h1 class="text-center">Championnat de double</h1>
                </div>
                <div class="panel-body">
                    @foreach($teams['double'] as $pool_number => $pools)
                        <h4>Poule
                            <button class="btn btn-info btn-circle">{{ $pool_number }}</button>
                            <div style="float: right;">
                                <a href="{{ route('championshipResult.show', [$pools['pool_id'], $championship->id]) }}" class="btn btn-primary btn-rounded">Résultats
                                    <span class="fa fa-area-chart"></span>
                                </a>
                            </div>
                        </h4>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Rang</th>
                                <th class="text-center">Points</th>
                                <th class="text-center">Joueur</th>
                                <th class="text-center">Matchs</th>
                                <th class="text-center">Gagné</th>
                                <th class="text-center">Perdu</th>
                                <th class="text-center">Non joué</th>
                                <th class="text-center">Gagné par forfait</th>
                                <th class="text-center">Perdu par forfait</th>
                                <th class="text-center">∆ Set</th>
                                <th class="text-center">∆ Points</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pools as $index => $doubleTeam)
                                @if($index !== 'pool_id')
                                    <tr class="text-center {{ $doubleTeam['userOne_id'] == $auth->id || $doubleTeam['userTwo_id'] == $auth->id ? 'text-danger' : ''}}">
                                        <td>{{ $doubleTeam['rank'] }}</td>
                                        <td>{{ $doubleTeam['points'] }}</td>
                                        <td>{{ $doubleTeam['name'] }}</td>
                                        <td>
                                            <span class="pie">{{ $doubleTeam['matchs'] }}</span>
                                        </td>
                                        <td>{{ $doubleTeam['match_won'] }}</td>
                                        <td>{{ $doubleTeam['match_lost'] }}</td>
                                        <td>{{ $doubleTeam['match_unplayed'] }}</td>
                                        <td>{{ $doubleTeam['match_won_by_wo'] }}</td>
                                        <td>{{ $doubleTeam['match_lost_by_wo'] }}</td>
                                        <td>{{ $doubleTeam['total_difference_set'] }}</td>
                                        <td>{{ $doubleTeam['total_difference_points'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="panel panel-danger">
            <div class="panel-heading">
                <h1 class="text-center">Championnat de mixte</h1>
            </div>
            <div class="panel-body">
                @foreach($teams['mixte'] as $pool_number => $pools)
                    <h4>Poule
                        <button class="btn btn-danger btn-circle">{{ $pool_number }}</button>
                        <div style="float: right;">
                            <a href="{{ route('championshipResult.show', [$pools['pool_id'], $championship->id]) }}" class="btn btn-primary btn-rounded">Résultats
                                <span class="fa fa-area-chart"></span>
                            </a>
                        </div>
                    </h4>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">Rang</th>
                            <th class="text-center">Points</th>
                            <th class="text-center">Joueur</th>
                            <th class="text-center">Matchs</th>
                            <th class="text-center">Gagné</th>
                            <th class="text-center">Perdu</th>
                            <th class="text-center">Non joué</th>
                            <th class="text-center">Gagné par forfait</th>
                            <th class="text-center">Perdu par forfait</th>
                            <th class="text-center">∆ Set</th>
                            <th class="text-center">∆ Points</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pools as $index => $mixteTeam)
                            @if($index !== 'pool_id')
                                <tr class="text-center {{ $mixteTeam['userOne_id'] == $auth->id || $mixteTeam['userTwo_id'] == $auth->id ? 'text-danger' : ''}}">
                                    <td>{{ $mixteTeam['rank'] }}</td>
                                    <td>{{ $mixteTeam['points'] }}</td>
                                    <td>{{ $mixteTeam['name'] }}</td>
                                    <td>
                                        <span class="pie">{{ $mixteTeam['matchs'] }}</span>
                                    </td>
                                    <td>{{ $mixteTeam['match_won'] }}</td>
                                    <td>{{ $mixteTeam['match_lost'] }}</td>
                                    <td>{{ $mixteTeam['match_unplayed'] }}</td>
                                    <td>{{ $mixteTeam['match_won_by_wo'] }}</td>
                                    <td>{{ $mixteTeam['match_lost_by_wo'] }}</td>
                                    <td>{{ $mixteTeam['total_difference_set'] }}</td>
                                    <td>{{ $mixteTeam['total_difference_points'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>

    @else
        <h1 class="text-center text-danger">Pas de championnat en ce moment !</h1>
    @endif

@stop

@section('javascript')
    <script>
        $.fn.peity.defaults.pie = {
            delimiter: null,
            fill: ["#676A6C", "#E3E3E3", "#ffd592"],
            height: 16,
            radius: 8,
            width: 16
        };
        $("span.pie").peity("pie");

        $(".chosen-select").chosen();
    </script>
@endsection