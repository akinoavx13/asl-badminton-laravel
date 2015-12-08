<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Réinitialiser le mot de passe</title>

    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

<br>
<br>

<div class="row">
    <div class="col-md-2 col-md-push-5">
        <img class="img-responsive" src="{{ asset('img/logo.png') }}" alt="logo"/>
    </div>
</div>

<br>

<div class="row">

    <div class="col-md-8 col-md-push-2">
        <h2 class="text-center">
            Bienvenue sur le site de l'AS Lectra Badminton,
        </h2>
        <span class="help-block text-center">merci de compléter les informations suivantes pour réinitialiser votre mot de passe</span>

        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    @include('flash.flash-session')
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="text-center">
                    Réinitialiser le mot de passe
                </h3>
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
    </div>
</div>

<script src="{{ asset('js/app.min.js') }}"></script>

</body>

</html>
