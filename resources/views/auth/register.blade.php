@extends('auth.layout')

@section('title')
    Créer un compte
@stop

@section('contentTitle')
    <span class="help-block">merci de compléter les informations suivantes pour créer votre compte</span>
@stop

@section('contentBody')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">
                Créer un compte
            </h2>
        </div>
        <div class="panel-body">

            <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

            {!! Form::open(['url' => '/auth/register', 'class' => 'form-horizontal']) !!}

            <div class="form-group">

                <div class="col-md-3">
                    {!! Form::label('name', 'Nom :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('email', 'Email :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('password', 'Mot de passe :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('password_confirmation', 'Confirmer :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group text-center">
                {!! Form::submit('Créer', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
