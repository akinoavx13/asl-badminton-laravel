@extends('auth.layout')

@section('title')
    Se connecter
@stop

@section('contentBody')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">
                Connexion
            </h2>
        </div>
        <div class="panel-body">

            {!! Form::open(['url' => '/login']) !!}

            <div class="form-group">
                {!! Form::email('email', old('email'), ['placeholder' => 'Email', 'class' => 'form-control', 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::password('password', ['placeholder' => 'Mot de passe', 'class' => 'form-control', 'required']) !!}
            </div>

            <div class="form-group text-center">
                <input type="checkbox" name="remember"> Se souvenir de moi
            </div>

            <p class="help-block text-center">
                <a href="{{ url('password/reset') }}" class="text-info">Mot de passe oublié ?</a>
            </p>

            <div class="form-group text-center">
                {!! Form::submit('Se connecter', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
