@extends('auth.layout')

@section('title')
    Réinitialiser le mot de passe
@stop

@section('contentTitle')
    <span class="help-block">merci de compléter les informations suivantes pour réinitialiser votre mot de passe</span>
@stop

@section('contentBody')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">
                Réinitialiser le mot de passe
            </h2>
        </div>
        <div class="panel-body">

            <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

            {!! Form::open(['url' => '/password/reset', 'class' => 'form-horizontal']) !!}

            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('Email', 'Email :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::email('email', old('email'), ['placeholder' => 'Email', 'class' => 'form-control', 'required']) !!}
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
                {!! Form::submit('Réinitialiser le mot de passe', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
