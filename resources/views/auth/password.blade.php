@extends('auth.layout')

@section('title')
    Mot de passe oublié
@stop

@section('contentTitle')
    <span class="help-block">merci de compléter les informations suivantes pour réinitialiser votre mot de passe</span>
@stop

@section('contentBody')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">
                Mot de passe oublié
            </h2>
        </div>
        <div class="panel-body">

            {!! Form::open(['url' => '/password/email']) !!}

            <div class="form-group">
                {!! Form::email('email', old('email'), ['placeholder' => 'Email', 'class' => 'form-control', 'required']) !!}
            </div>

            <div class="form-group text-center">
                {!! Form::submit('Envoyer le lien de réinitialisation', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@stop
