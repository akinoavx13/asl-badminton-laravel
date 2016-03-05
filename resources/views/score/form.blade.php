<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1 class="text-center">Rentrer un score</h1>
    </div>
    <div class="ibox-content">

        {!! Form::open(['route' => ['score.update', $score->id, $pool_id, str_replace(' ', '-', $firstTeamName), str_replace(' ', '-', $secondTeamName), $anchor], 'class' => 'form-horizontal', 'files' => 'true']) !!}

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">
                            {{ $firstTeamName }}
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            {!! Form::number('first_set_first_team', $score->exists ? $score->first_set_first_team : old('first_set_first_team'), ['class' => 'form-control', 'tabindex' => '1']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            {!! Form::number('second_set_first_team', $score->exists ? $score->second_set_first_team : old('second_set_first_team'), ['class' => 'form-control', 'tabindex' => '3']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            {!! Form::number('third_set_first_team', $score->exists ? $score->third_set_first_team : old('third_set_first_team'), ['class' => 'form-control', 'tabindex' => '5']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4 text-center">
                        <div class="form-group">
                            {!! Form::radio('wo', 'my_wo', $score->exists ? $score->hasMyWo(true) ? true : false : false) !!}
                            Forfait
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center text-danger">VS</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">/</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">/</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">/</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">
                            {{ $secondTeamName }}
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            {!! Form::number('first_set_second_team', $score->exists ? $score->first_set_second_team : old('first_set_second_team'), ['class' => 'form-control', 'tabindex' => '2']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            {!! Form::number('second_set_second_team', $score->exists ? $score->second_set_second_team : old('second_set_second_team'), ['class' => 'form-control', 'tabindex' => '4']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            {!! Form::number('third_set_second_team', $score->exists ? $score->third_set_second_team : old('third_set_second_team'), ['class' => 'form-control', 'tabindex' => '6']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4 text-center">
                        <div class="form-group">
                            {!! Form::radio('wo', 'his_wo', $score->exists ? $score->hasHisWo(true) ? true : false : false) !!}
                            Forfait
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-4 col-md-4 text-center">
                <div class="form-group">
                    {!! Form::checkbox('unplayed', '1', false) !!}
                    Non joué
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2', 'placeholder' => 'Votre commentaire ...']) !!}
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                {!! Form::file('photo', ['accept' => 'image/*']) !!}
            </div>
        </div>

        <div class="form-group text-center">
            {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>
