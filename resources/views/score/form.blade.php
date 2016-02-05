<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1 class="text-center">Rentrer un score</h1>
    </div>
    <div class="ibox-content">

        {!! Form::open(['route' => ['score.update', $score->id, $pool_id], 'class' => 'form-horizontal']) !!}

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h2 class="text-center">Premier set</h2>
                    </div>
                    <div class="panel-content">
                        <br>
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-3">
                                {!! Form::label('first_set_first_team', 'Équipe 1 :', ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-7">
                                {!! Form::number('first_set_first_team', $score->exists ? $score->first_set_first_team : old('first_set_first_team'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-3">
                                {!! Form::label('first_set_second_team', 'Équipe 2 :', ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-7">
                                {!! Form::number('first_set_second_team', $score->exists ? $score->first_set_second_team : old('first_set_second_team'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="text-center">Deuxième set</h2>
                    </div>
                    <div class="panel-content">
                        <br>
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-3">
                                {!! Form::label('second_set_first_team', 'Équipe 1 :', ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-7">
                                {!! Form::number('second_set_first_team', $score->exists ? $score->second_set_first_team : old('second_set_first_team'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-3">
                                {!! Form::label('second_set_second_team', 'Équipe 2 :', ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-7">
                                {!! Form::number('second_set_second_team', $score->exists ? $score->second_set_second_team : old('second_set_second_team'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h2 class="text-center">Troisième set</h2>
                    </div>
                    <div class="panel-content">
                        <br>
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-3">
                                {!! Form::label('third_set_first_team', 'Équipe 1 :', ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-7">
                                {!! Form::number('third_set_first_team', $score->exists ? $score->third_set_first_team : old('third_set_first_team'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-3">
                                {!! Form::label('third_set_second_team', 'Équipe 2 :', ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-7">
                                {!! Form::number('third_set_second_team', $score->exists ? $score->third_set_second_team : old('third_set_second_team'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h2 class="text-center">Paramètres</h2>
                    </div>
                    <div class="panel-content">
                        <br>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-3">
                                {!! Form::label('my_wo', 'Mon forfait :', ['class' => 'control-label']) !!}
                                <i class="text-navy">*</i>
                            </div>

                            <div class="col-md-6">
                                <div class="radio-inline">
                                    <label>
                                        {!! Form::radio('my_wo', '1', $score->exists ? $score->hasMyWo(true) ? true : false : false, ['required']) !!}
                                        Oui
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        {!! Form::radio('my_wo', '0', $score->exists ? $score->hasMyWo(false) ? true : false : true, ['required']) !!}
                                        Non
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-3">
                                {!! Form::label('his_wo', 'Son forfait :', ['class' => 'control-label']) !!}
                                <i class="text-navy">*</i>
                            </div>

                            <div class="col-md-6">
                                <div class="radio-inline">
                                    <label>
                                        {!! Form::radio('his_wo', '1', $score->exists ? $score->hasHisWo(true) ? true : false : false, ['required']) !!}
                                        Oui
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        {!! Form::radio('his_wo', '0', $score->exists ? $score->hasHisWo(false) ? true : false : true, ['required']) !!}
                                        Non
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-3">
                                {!! Form::label('unplayed', 'Non joué :', ['class' => 'control-label']) !!}
                                <i class="text-navy">*</i>
                            </div>

                            <div class="col-md-6">
                                <div class="radio-inline">
                                    <label>
                                        {!! Form::radio('unplayed', '1', $score->exists ? $score->hasUnplayed(true) ? true : false :
                                        false, ['required']) !!}
                                        Oui
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        {!! Form::radio('unplayed', '0', $score->exists ? $score->hasUnplayed(false) ? true : false : true, ['required']) !!}
                                        Non
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group text-center">
            {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>
