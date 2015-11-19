<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mot de passe oublié</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

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

    <div class="col-md-6 col-md-push-3">
        <h2 class="text-center">
            Bienvenue sur le site de l'AS Lectra Badminton
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
                    Mot de passe oublié
                </h3>
            </div>
            <div class="panel-body">

                {!! Form::open(['url' => '/password/email']) !!}

                {!! Form::token() !!}

                <div class="form-group">
                    {!! Form::email('email', old('email'), ['placeholder' => 'Email', 'class' => 'form-control', 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Envoyer le lien de réinitialisation', ['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>


<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

</html>
