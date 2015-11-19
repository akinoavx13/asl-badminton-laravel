<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <div class="text-center">
                        <span>
                            @if($auth->avatar)
                                <img src="{{ url($auth->avatar) }}"
                                     class="img-circle" alt="logo" width="50" height="50"/>
                            @else
                                <img src="{{ asset('img/anonymous.png') }}"
                                     class="img-circle" alt="logo" width="50" height="50"/>
                            @endif
                        </span>
                    </div>
                    <a data-toggle="dropdown" class="dropdown-toggle text-center" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">
                                    {{ $auth }}
                                </strong>
                            </span>
                            <span class="text-muted text-xs block">
                                <span>
                                    @if($auth->hasRole('admin'))
                                        Administrateur
                                    @else
                                        Utilisateur
                                    @endif
                                </span>
                                <b class="caret"></b>
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="{{ route('user.edit', $auth->id) }}">Mon profil</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('auth/logout') }}">Se déconnecter</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ route('home.index') }}">
                    <i class="fa fa-home"></i>
                    <span class="nav-label">Accueil</span>
                </a>
            </li>

            @if($auth->hasRole('admin'))
                <li>
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span class="nav-label">Utilisateurs</span>
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('user.index') }}"><i class="fa fa-list"></i>Liste des utilisateurs</a>
                        </li>
                        <li><a href="#"><i class="fa fa-user-plus"></i>Créer unutilisateur</a></li>
                    </ul>
                </li>
            @endif

        </ul>
    </div>
</nav>