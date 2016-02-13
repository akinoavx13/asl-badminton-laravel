@extends('layout')

@section('title')
    Changer de mot de passe
@stop

@section('content')



    <div class="row">
        <div class="col-md-push-1 col-md-10">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h1 class="text-center">
                        Changer de mot de passe
                    </h1>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['user.changePassword', $user_id], 'class' => 'form-horizontal']) !!}

                    <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>


                    <div class="form-group">
                        <div class="col-md-3">
                            {!! Form::label('password', 'Mot de passe :', ['class' => 'control-label']) !!}
                            <i class="text-navy">*</i>
                        </div>
                        <div class="col-md-9">
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            {!! Form::label('password_confirmation', 'Confirmer :', ['class' => 'control-label']) !!}
                            <i class="text-navy">*</i>
                        </div>
                        <div class="col-md-9">
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group text-center">
                        {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop