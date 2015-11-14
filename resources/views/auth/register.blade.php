<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Créer un compte</title>

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

    <div class="col-md-8 col-md-push-2">
        <h2 class="text-center">
            Bienvenue sur le site de l'AS Lectra Badminton,
        </h2>
        <span class="help-block text-center">merci de compléter les informations suivantes pour créer votre compte</span>

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
                    Créer un compte
                </h3>
            </div>
            <div class="panel-body">

                <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

                <form method="POST" action="{{ url('/auth/register') }}" class="form-horizontal">

                    <input name="_token" value="{{ csrf_token() }}" type="hidden"/>

                    <div class="form-group">

                        <div class="col-md-3">
                            <label for="name" class="control-label">Nom :</label>
                            <i class="text-navy">*</i>
                        </div>

                        <div class="col-md-9">
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control"
                                   value="{{ old('name') }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="email" class="control-label">Email :</label>
                            <i class="text-navy">*</i>
                        </div>
                        <div class="col-md-9">
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   value="{{ old('email') }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="password" class="control-label">Mot de passe :</label>
                            <i class="text-navy">*</i>
                        </div>
                        <div class="col-md-9">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   value="{{ old('password') }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="password_confirmation" class="control-label">Confirmer :</label>
                            <i class="text-navy">*</i>
                        </div>
                        <div class="col-md-9">
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   value="{{ old('password_confirmation') }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Créer</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

</html>
