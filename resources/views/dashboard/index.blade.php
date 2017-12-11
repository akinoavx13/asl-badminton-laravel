@extends('layout')

@section('title')
    Tableau de bord
@stop

@section('content')

    <h1 class="text-center">Tableau de bord </h1>
    <h2 class="text-center"> <a href="{{ route('stat.show', $userID) }}">(nouveau: vos statistiques en simple)</a></h2>
    <hr>

    @if(count($tableReservation['simple']) <= 0 && count($tableReservation['double']) <= 0 && count($tableReservation['mixte']) <= 0)
        <h2 class="text-center text-danger">
            Vous ne participez pas au championnat : simple, double, mixte
        </h2>
        @else
        @foreach(['simple', 'double', 'mixte'] as $type)
            @if(count($tableReservation[$type]) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel {{ $type == 'simple' ? 'panel-warning' : '' }} {{ $type == 'double' ? 'panel-info' : '' }} {{ $type == 'mixte' ? 'panel-danger' : '' }}">
                            <div class="panel-heading">
                                <h1 class="text-center">Championnat de {{ $type }} (Poule n° {{ $pools[$type]['pool_number'] }})</h1>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Photo</th>
                                        <th class="text-center">Adversaire</th>
                                        <th class="text-center">Rang</th>
                                        <th class="text-center">État</th>
                                        <th class="text-center">Réserver</th>
                                        <th class="text-center">Résultat</th>
                                        <th class="text-center">Contacter</th>
                                        <th class="text-center">Éditer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tableReservation[$type] as $resum)
                                        <tr class="text-center">
                                            <td>
                                                @if($type == 'simple')
                                                    @if($resum['imTheFirstTeam'])
                                                        @if($resum['userSecondTeamAvatar'])
                                                            <img src="{{ asset('img/avatars/' . $resum['userSecondTeamId'] . '.jpg') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @else
                                                            <img src="{{ asset('img/anonymous.png') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @endif
                                                    @else
                                                        @if($resum['userFirstTeamAvatar'])
                                                            <img src="{{ asset('img/avatars/' . $resum['userFirstTeamId'] . '.jpg') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @else
                                                            <img src="{{ asset('img/anonymous.png') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if($resum['imTheFirstTeam'])
                                                        @if($resum['userOneSecondTeamAvatar'])
                                                            <img src="{{ asset('img/avatars/' . $resum['userOneSecondTeamId'] . '.jpg') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @else
                                                            <img src="{{ asset('img/anonymous.png') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @endif
                                                        @if($resum['userTwoSecondTeamAvatar'])
                                                            <img src="{{ asset('img/avatars/' . $resum['userTwoSecondTeamId'] . '.jpg') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @else
                                                            <img src="{{ asset('img/anonymous.png') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @endif
                                                    @else
                                                        @if($resum['userOneFirstTeamAvatar'])
                                                            <img src="{{ asset('img/avatars/' . $resum['userOneFirstTeamId'] . '.jpg') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @else
                                                            <img src="{{ asset('img/anonymous.png') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @endif
                                                        @if($resum['userTwoFirstTeamAvatar'])
                                                            <img src="{{ asset('img/avatars/' . $resum['userTwoFirstTeamId'] . '.jpg') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @else
                                                            <img src="{{ asset('img/anonymous.png') }}"
                                                                 class="img-circle" alt="logo" width="50" height="50"/>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($type == 'simple')
                                                    @if($resum['imTheFirstTeam'])
                                                        <a href="{{ route('user.show', $resum['userSecondTeamId']) }}">{{ $resum['userSecondTeamName'] }}</a>
                                                    @else
                                                        <a href="{{ route('user.show', $resum['userFirstTeamId']) }}">{{ $resum['userFirstTeamName'] }}</a>
                                                    @endif
                                                @else
                                                    @if($resum['imTheFirstTeam'])
                                                        <a href="{{ route('user.show', $resum['userOneSecondTeamId']) }}">{{ $resum['userOneSecondTeamName'] }}</a>
                                                        &
                                                        <a href="{{ route('user.show', $resum['userTwoSecondTeamId']) }}">{{ $resum['userTwoSecondTeamName'] }}</a>
                                                    @else
                                                        <a href="{{ route('user.show', $resum['userOneFirstTeamId']) }}">{{ $resum['userOneFirstTeamName'] }}</a>
                                                        &
                                                        <a href="{{ route('user.show', $resum['userTwoFirstTeamId']) }}">{{ $resum['userTwoFirstTeamName'] }}</a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($resum['imTheFirstTeam'])
                                                    @if($resum['rankSecondTeam'] == 0)
                                                        <span class="text-danger">
                                                    Pas encore classé
                                                </span>
                                                    @else
                                                        {{ $resum['rankSecondTeam'] }}
                                                    @endif
                                                @else
                                                    @if($resum['rankFirstTeam'] == 0)
                                                        <span class="text-danger">
                                                    Pas encore classé
                                                </span>
                                                    @else
                                                        {{ $resum['rankFirstTeam'] }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($type == 'simple')
                                                    @if($resum['imTheFirstTeam'])
                                                        @if($resum['userSecondTeamState'] == 'holiday')
                                                            <span class="text-danger">En vacances jusqu'au {{ $resum['userSecondTeamEndingHoliday'] }}</span>
                                                        @elseif($resum['userSecondTeamState'] == 'hurt')
                                                            <span class="text-danger">Bléssé jusqu'au {{ $resum['userSecondTeamEndingInjury'] }}</span>
                                                        @elseif($resum['userSecondTeamState'] == 'active')
                                                            <span class="text-primary">Actif</span>
                                                        @elseif($resum['userSecondTeamState'] == 'inactive')
                                                            <span class="text-danger">Inactif</span>
                                                        @endif
                                                    @else
                                                        @if($resum['userFirstTeamState'] == 'holiday')
                                                            <span class="text-danger">En vacances jusqu'au {{ $resum['userFirstTeamEndingHoliday'] }}</span>
                                                        @elseif($resum['userFirstTeamState'] == 'hurt')
                                                            <span class="text-danger">Bléssé jusqu'au {{ $resum['userFirstTeamEndingInjury'] }}</span>
                                                        @elseif($resum['userFirstTeamState'] == 'active')
                                                            <span class="text-navy">Actif</span>
                                                        @elseif($resum['userFirstTeamState'] == 'inactive')
                                                            <span class="text-danger">Inactif</span>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if($resum['imTheFirstTeam'])
                                                        @if($resum['userOneSecondTeamState'] == 'holiday')
                                                            <span class="text-danger">En vacances jusqu'au {{ $resum['userOneSecondTeamEndingHoliday'] }}</span>
                                                        @elseif($resum['userOneSecondTeamState'] == 'hurt')
                                                            <span class="text-danger">Bléssé jusqu'au {{ $resum['userOneSecondTeamEndingInjury'] }}</span>
                                                        @elseif($resum['userOneSecondTeamState'] == 'active')
                                                            <span class="text-navy">Actif</span>
                                                        @elseif($resum['userOneSecondTeamState'] == 'inactive')
                                                            <span class="text-danger">Inactif</span>
                                                        @endif
                                                        &
                                                        @if($resum['userTwoSecondTeamState'] == 'holiday')
                                                            <span class="text-danger">En vacances jusqu'au {{ $resum['userTwoSecondTeamEndingHoliday'] }}</span>
                                                        @elseif($resum['userTwoSecondTeamState'] == 'hurt')
                                                            <span class="text-danger">Bléssé jusqu'au {{ $resum['userTwoSecondTeamEndingInjury'] }}</span>
                                                        @elseif($resum['userTwoSecondTeamState'] == 'active')
                                                            <span class="text-navy">Actif</span>
                                                        @elseif($resum['userTwoSecondTeamState'] == 'inactive')
                                                            <span class="text-danger">Inactif</span>
                                                        @endif
                                                    @else
                                                        @if($resum['userOneFirstTeamState'] == 'holiday')
                                                            <span class="text-danger">En vacances jusqu'au {{ $resum['userOneFirstTeamEndingHoliday'] }}</span>
                                                        @elseif($resum['userOneFirstTeamState'] == 'hurt')
                                                            <span class="text-danger">Bléssé jusqu'au {{ $resum['userOneFirstTeamEndingInjury'] }}</span>
                                                        @elseif($resum['userOneFirstTeamState'] == 'active')
                                                            <span class="text-navy">Actif</span>
                                                        @elseif($resum['userOneFirstTeamState'] == 'inactive')
                                                            <span class="text-danger">Inactif</span>
                                                        @endif
                                                        &
                                                        @if($resum['userTwoFirstTeamState'] == 'holiday')
                                                            <span class="text-danger">En vacances jusqu'au {{ $resum['userTwoFirstTeamEndingHoliday'] }}</span>
                                                        @elseif($resum['userTwoFirstTeamState'] == 'hurt')
                                                            <span class="text-danger">Bléssé jusqu'au {{
                                                            $resum['userTwoFirstTeamEndingInjury'] }}</span>
                                                        @elseif($resum['userTwoFirstTeamState'] == 'active')
                                                            <span class="text-navy">Actif</span>
                                                        @elseif($resum['userTwoFirstTeamState'] == 'inactive')
                                                            <span class="text-danger">Inactif</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($resum['reservation'] == null)
                                                    <a href="{{ route('reservation.index') }}">Réserver un terrain</a>
                                                @else
                                                    {{ $resum['reservation'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($resum['unplayed'])
                                                    <span class="text-danger">Non joué</span>
                                                @elseif($resum['imTheFirstTeam'])
                                                    @if($resum['myWo'])
                                                        Perdu par wo
                                                    @elseif($resum['hisWo'])
                                                        Gagné par wo
                                                    @endif
                                                @endif
                                                @if($resum['firstSetFirstTeam'] != 0 && $resum['firstSetSecondTeam'] != 0)
                                                    {{ $resum['firstSetFirstTeam'] }}
                                                    <span class="text-danger">/</span>
                                                    {{ $resum['firstSetSecondTeam'] }}
                                                    -
                                                    {{ $resum['secondSetFirstTeam'] }}
                                                    <span class="text-danger">/</span>
                                                    {{ $resum['secondSetSecondTeam'] }}
                                                    @if($resum['thirdSetFirstTeam'] != 0 && $resum['thirdSetSecondTeam'] != 0)
                                                        -
                                                        {{ $resum['thirdSetFirstTeam'] }}
                                                        <span class="text-danger">/</span>
                                                        {{ $resum['thirdSetSecondTeam'] }}
                                                    @endif
                                                @endif
                                                @if($resum['imTheFirstTeam'] && $resum['isFirstTeamWin'])
                                                    <p class="text-navy">
                                                        Gagné {{ $resum['hisWo'] ? " par WO" : "" }} !
                                                    </p>
                                                @elseif($resum['imTheFirstTeam'] && $resum['isSecondTeamWin'])
                                                    <p class="text-danger">
                                                        Perdu {{ $resum['myWo'] ? " par WO" : "" }} !
                                                    </p>
                                                @elseif(!$resum['imTheFirstTeam'] && $resum['isFirstTeamWin'])
                                                    <p class="text-danger">
                                                        Perdu {{ $resum['hisWo'] ? " par WO" : "" }} !
                                                    </p>
                                                @elseif(!$resum['imTheFirstTeam'] && $resum['isSecondTeamWin'])
                                                    <p class="text-navy">
                                                        Gagné {{ $resum['myWo'] ? " par WO" : "" }} !
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if($type == 'simple')
                                                    @if($resum['imTheFirstTeam'])
                                                        <a href="mailto:{{ $resum['userSecondTeamEmail'] }}?Subject=AS Lectra Badminton réservation"
                                                           target="_top"><i class="fa fa-send"></i></a>
                                                    @else
                                                        <a href="mailto:{{ $resum['userFirstTeamEmail'] }}?Subject=AS Lectra Badminton réservation"
                                                           target="_top"><i class="fa fa-send"></i></a>
                                                    @endif
                                                @else
                                                    @if($resum['imTheFirstTeam'])
                                                        <a href="mailto:{{ $resum['userOneSecondTeamEmail'] }};{{ $resum['userTwoSecondTeamEmail'] }}?Subject=AS Lectra Badminton réservation"target="_top"><i class="fa fa-send"></i></a>
                                                    @else
                                                        <a href="mailto:{{ $resum['userOneFirstTeamEmail'] }};{{ $resum['userTwoFirstTeamEmail'] }}?Subject=AS Lectra Badminton réservation"target="_top"><i class="fa fa-send"></i></a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($type == 'simple')
                                                    <a href="{{ route('score.edit', [$resum['scoreId'], $pools[$type]['pool_id'],
                                        str_replace(' ', '-', $resum['userFirstTeamName']),
                                        str_replace(' ', '-', $resum['userSecondTeamName']), $anchor[$type]]) }}" class="btn btn-primary">
                                                        <span class="fa fa-edit"></span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('score.edit', [$resum['scoreId'], $pools[$type]['pool_id'],
                                        str_replace(' ', '-', $resum['userOneFirstTeamName'] . ' & ' . $resum['userTwoFirstTeamName']),
                                        str_replace(' ', '-', $resum['userOneSecondTeamName'] . ' & ' . $resum['userTwoSecondTeamName']),
                                        $anchor[$type]]) }}" class="btn btn-primary">
                                                        <span class="fa fa-edit"></span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

@stop
