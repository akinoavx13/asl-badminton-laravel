<div class="ibox float-e-margins">
    <div class="ibox-title">
        @if($period->exists)
            <h1 class="text-center">Modification du championnat {{ $period }}</h1>
        @else
            <h1 class="text-center">Création d'un championnat</h1>
        @endif
    </div>
    <div class="ibox-content">

        {!! Form::open(['route' => 'championship.store', 'class' => 'form-horizontal']) !!}

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('start', 'Début :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                {!! Form::text('start', $period->exists ? $period->start : old('start'), ['class' => 'form-control',
                'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('end', 'Fin :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                {!! Form::text('end', $period->exists ? $period->end : old('end'), ['class' => 'form-control',
                'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy', 'required']) !!}
            </div>
        </div>

        @if($setting->hasChampionshipSimpleWoman(true))
            @foreach(['man', 'woman'] as $gender)
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h1 class="text-center">Equipe de simple {{ $gender == 'man' ? 'homme' : 'femme'  }}</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-center">
                                    Nombre de poule de 3 : <span class="text-navy">{{ $poolsNumber['simple'][$gender]['3'] }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-center">
                                    Nombre de poule de 4 : <span class="text-navy">{{ $poolsNumber['simple'][$gender]['4'] }}</span>
                                </p>
                            </div>
                        </div>
                        <table class="table table-striped table-hover" id="simple_{{ $gender }}">
                            <thead>
                            <tr>
                                <th class="text-center">Equipe</th>
                                <th class="text-center">Actif</th>
                                <th class="text-center">Rang</th>
                                <th class="text-center">N° poule <i class="text-navy">*</i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teams['simple'][$gender] as $simpleTeam)
                                <tr class="text-center">
                                    <td>{{ $simpleTeam['name'] }}</td>
                                    <td>
                                        @if($simpleTeam['state'] === 'active')
                                            <i class="text-navy">Actif</i>
                                        @elseif($simpleTeam['state'] === 'inactive')
                                            <i class="text-warning">Inactif</i>
                                        @elseif($simpleTeam['state'] === 'holiday')
                                            <i class="text-warning">En vacances jusqu'au {{ $simpleTeam['ending_holiday'] }}</i>
                                        @elseif($simpleTeam['state'] === 'hurt')
                                            <i class="text-danger">Blessé
                                                jusqu'au {{ $simpleTeam['ending_injury'] }}</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($simpleTeam['rank'] == 'new')
                                            <i class="text-danger">Nouveau !</i>
                                        @else
                                            <i class="text-navy">{{ $simpleTeam['pool_number'] }} /
                                                {{ $simpleTeam['rank'] }}
                                            </i>
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::text('pool_number_simple_' . $gender . '[' . $simpleTeam['id'] . ']', old('number') ,[ 'class' => 'form-control']) !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h1 class="text-center">Equipe de simple</h1>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-center">
                                Nombre de poule de 3 : <span class="text-navy">{{ $poolsNumber['simple']['3'] }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-center">
                                Nombre de poule de 4 : <span class="text-navy">{{ $poolsNumber['simple']['4'] }}</span>
                            </p>
                        </div>
                    </div>
                    <table class="table table-striped table-hover" id="simple">
                        <thead>
                        <tr>
                            <th class="text-center">Equipe</th>
                            <th class="text-center">Actif</th>
                            <th class="text-center">Rang</th>
                            <th class="text-center">N° poule <i class="text-navy">*</i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teams['simple'] as $simpleTeam)
                            <tr class="text-center">
                                <td>{{ $simpleTeam['name'] }}</td>
                                <td>
                                    @if($simpleTeam['state'] === 'active')
                                        <i class="text-navy">Actif</i>
                                    @elseif($simpleTeam['state'] === 'inactive')
                                        <i class="text-warning">Inactif</i>
                                    @elseif($simpleTeam['state'] === 'holiday')
                                        <i class="text-warning">En vacances jusqu'au {{ $simpleTeam['ending_holiday'] }}</i>
                                    @elseif($simpleTeam['state'] === 'hurt')
                                        <i class="text-danger">Blessé
                                            jusqu'au {{ $simpleTeam['ending_injury'] }}</i>
                                    @endif
                                </td>
                                <td>
                                    @if($simpleTeam['rank'] == 'new')
                                        <i class="text-danger">Nouveau !</i>
                                    @else
                                        <i class="text-navy">{{ $simpleTeam['pool_number'] }} /
                                            {{ $simpleTeam['rank'] }}</i>
                                    @endif
                                </td>
                                <td>
                                    {!! Form::text('pool_number_simple[' . $simpleTeam['id'] . ']', old('number') ,['class' => 'form-control']) !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($setting->hasChampionshipDoubleWoman(true))
            @foreach(['man', 'woman'] as $gender)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h1 class="text-center">Equipe de double {{ $gender == 'man' ? 'homme' : 'femme' }}</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-center">
                                    Nombre de poule de 3 : <span class="text-navy">{{ $poolsNumber['double'][$gender]['3'] }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-center">
                                    Nombre de poule de 4 : <span class="text-navy">{{ $poolsNumber['double'][$gender]['4'] }}</span>
                                </p>
                            </div>
                        </div>
                        <table class="table table-striped table-hover" id="double_{{ $gender }}">
                            <thead>
                            <tr>
                                <th class="text-center">Equipe</th>
                                <th class="text-center">Actif</th>
                                <th class="text-center">Rang</th>
                                <th class="text-center">N° poule <i class="text-navy">*</i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teams['double'][$gender] as $doubleTeam)
                                <tr class="text-center">
                                    <td>{{ $doubleTeam['name'] }}</td>
                                    <td>
                                        @if($doubleTeam['stateOne'] === 'active')
                                            <i class="text-navy">Actif</i>
                                        @elseif($doubleTeam['stateOne'] === 'inactive')
                                            <i class="text-warning">Inactif</i>
                                        @elseif($doubleTeam['stateOne'] === 'holiday')
                                            <i class="text-warning">En vacances jusqu'au {{ $doubleTeam['ending_holidayOne'] }}</i>
                                        @elseif($doubleTeam['stateOne'] === 'hurt')
                                            <i class="text-danger">Blessé jusqu'au {{ $doubleTeam['ending_injuryOne'] }}</i>
                                        @endif
                                        &
                                        @if($doubleTeam['stateTwo'] === 'active')
                                            <i class="text-navy">Actif</i>
                                        @elseif($doubleTeam['stateTwo'] === 'inactive')
                                            <i class="text-warning">Inactif</i>
                                        @elseif($doubleTeam['stateTwo'] === 'holiday')
                                            <i class="text-warning">En vacances jusqu'au {{ $doubleTeam['ending_holidayTwo'] }}</i>
                                        @elseif($doubleTeam['stateTwo'] === 'hurt')
                                            <i class="text-danger">Blessé jusqu'au {{ $doubleTeam['ending_injuryTwo'] }}</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($doubleTeam['rank'] == 'new')
                                            <i class="text-danger">Nouveau !</i>
                                        @else
                                            <i class="text-navy">{{ $doubleTeam['pool_number'] }} /
                                                {{ $doubleTeam['rank'] }}</i>
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::text('pool_number_double_' . $gender . '[' . $doubleTeam['id'] . ']', old('number') ,['class' => 'form-control']) !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h1 class="text-center">Equipe de double</h1>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-center">
                                Nombre de poule de 3 : <span class="text-navy">{{ $poolsNumber['double']['3'] }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-center">
                                Nombre de poule de 4 : <span class="text-navy">{{ $poolsNumber['double']['4'] }}</span>
                            </p>
                        </div>
                    </div>
                    <table class="table table-striped table-hover" id="double">
                        <thead>
                        <tr>
                            <th class="text-center">Equipe</th>
                            <th class="text-center">Actif</th>
                            <th class="text-center">Rang</th>
                            <th class="text-center">N° poule <i class="text-navy">*</i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teams['double'] as $doubleTeam)
                            <tr class="text-center">
                                <td>{{ $doubleTeam['name'] }}</td>
                                <td>
                                    @if($doubleTeam['stateOne'] === 'active')
                                        <i class="text-navy">Actif</i>
                                    @elseif($doubleTeam['stateOne'] === 'inactive')
                                        <i class="text-warning">Inactif</i>
                                    @elseif($doubleTeam['stateOne'] === 'holiday')
                                        <i class="text-warning">En vacances jusqu'au {{ $doubleTeam['ending_holidayOne'] }}</i>
                                    @elseif($doubleTeam['stateOne'] === 'hurt')
                                        <i class="text-danger">Blessé jusqu'au {{ $doubleTeam['ending_injuryOne'] }}</i>
                                    @endif
                                    &
                                    @if($doubleTeam['stateTwo'] === 'active')
                                        <i class="text-navy">Actif</i>
                                    @elseif($doubleTeam['stateTwo'] === 'inactive')
                                        <i class="text-warning">Inactif</i>
                                    @elseif($doubleTeam['stateTwo'] === 'holiday')
                                        <i class="text-warning">En vacances jusqu'au {{ $doubleTeam['ending_holidayTwo'] }}</i>
                                    @elseif($doubleTeam['stateTwo'] === 'hurt')
                                        <i class="text-danger">Blessé jusqu'au {{ $doubleTeam['ending_injuryTwo'] }}</i>
                                    @endif
                                </td>
                                <td>
                                    @if($doubleTeam['rank'] == 'new')
                                        <i class="text-danger">Nouveau !</i>
                                    @else
                                        <i class="text-navy">{{ $doubleTeam['pool_number'] }} /
                                            {{ $doubleTeam['rank'] }}</i>
                                    @endif
                                </td>
                                <td>
                                    {!! Form::text('pool_number_double[' . $doubleTeam['id'] . ']', old('number') ,['class' => 'form-control']) !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="panel panel-danger">
            <div class="panel-heading">
                <h1 class="text-center">Equipe de mixte</h1>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-center">
                            Nombre de poule de 3 : <span class="text-navy">{{ $poolsNumber['mixte']['3'] }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-center">
                            Nombre de poule de 4 : <span class="text-navy">{{ $poolsNumber['mixte']['4'] }}</span>
                        </p>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="mixte">
                    <thead>
                    <tr>
                        <th class="text-center">Equipe</th>
                        <th class="text-center">Actif</th>
                        <th class="text-center">Rang</th>
                        <th class="text-center">N° poule <i class="text-navy">*</i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teams['mixte'] as $mixteTeam)
                        <tr class="text-center">
                            <td>{{ $mixteTeam['name'] }}</td>
                            <td>
                                @if($mixteTeam['stateOne'] === 'active')
                                    <i class="text-navy">Actif</i>
                                @elseif($mixteTeam['stateOne'] === 'inactive')
                                    <i class="text-warning">Inactif</i>
                                @elseif($mixteTeam['stateOne'] === 'holiday')
                                    <i class="text-warning">En vacances jusqu'au {{ $mixteTeam['ending_holidayOne'] }}</i>
                                @elseif($mixteTeam['stateOne'] === 'hurt')
                                    <i class="text-danger">Blessé jusqu'au {{ $mixteTeam['ending_injuryOne'] }}</i>
                                @endif
                                &
                                @if($mixteTeam['stateTwo'] === 'active')
                                    <i class="text-navy">Actif</i>
                                @elseif($mixteTeam['stateTwo'] === 'inactive')
                                    <i class="text-warning">Inactif</i>
                                @elseif($mixteTeam['stateTwo'] === 'holiday')
                                    <i class="text-warning">En vacances jusqu'au {{ $mixteTeam['ending_holidayTwo'] }}</i>
                                @elseif($mixteTeam['stateTwo'] === 'hurt')
                                    <i class="text-danger">Blessé jusqu'au {{ $mixteTeam['ending_injuryTwo'] }}</i>
                                @endif
                            </td>
                            <td>
                                @if($mixteTeam['rank'] == 'new')
                                    <i class="text-danger">Nouveau !</i>
                                @else
                                    <i class="text-navy">{{ $mixteTeam['pool_number'] }} /
                                        {{ $mixteTeam['rank'] }}</i>
                                @endif
                            </td>
                            <td>
                                {!! Form::text('pool_number_mixte[' . $mixteTeam['id'] . ']', old('number') ,[ 'class' => 'form-control']) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($period->exists)
            <div class="form-group text-center">
                {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
            </div>
        @else
            <div class="form-group text-center">
                {!! Form::submit('Créer', ['class' => 'btn btn-primary']) !!}
            </div>
        @endif

        {!! Form::close() !!}

    </div>
</div>
