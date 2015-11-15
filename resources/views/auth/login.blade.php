<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Se connecter</title>

    <link href="{{ asset('css/bootstrap.min.css') }}"
          rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}"
          rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}"
          rel="stylesheet">
    <link href="{{ asset('css/style.css') }}"
          rel="stylesheet">

</head>

<body class="gray-bg">

<br>
<br>

<div class="row">
    <div class="col-md-2 col-md-push-5">
        <img class="img-responsive"
             src="{{ asset('img/logo.png') }}"
             alt="logo" />
    </div>
</div>

<br>

<div class="row">

    <div class="col-md-6 col-md-push-3">
        <h2 class="text-center">
            Bienvenue sur le site de l'AS Lectra Badminton
        </h2>

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
                    Connexion
                </h3>
            </div>
            <div class="panel-body">

                <form method="POST"
                      action="{{ url('/auth/login') }}">

                    <input name="_token"
                           value="{{ csrf_token() }}"
                           type="hidden" />

                    <div class="form-group">
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               placeholder="Email"
                               required>
                    </div>

                    <div class="form-group">
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               value="{{ old('password') }}"
                               placeholder="Mot de passe"
                               required>
                    </div>

                    <div class="form-group text-center">
                        <input type="checkbox"
                               name="remember"> Se souvenir de moi
                    </div>

                    <p class="help-block text-center">Vous n'avez pas de compte ?
                        <a href="{{ url('auth/register') }}"
                           class="text-info">Créer un compte</a>
                    </p>

                    <p class="help-block text-center">
                        <a href="{{ url('password/email') }}"
                           class="text-info">Mot de passe oublié ?</a>
                    </p>

                    <div class="form-group text-center">
                        <button type="submit"
                                class="btn btn-primary">Se connecter</button>
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
