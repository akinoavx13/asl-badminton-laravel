<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <div class="text-center">
                        <span>
                            @if($auth->avatar)
                                <img src="{{ asset($auth->avatar) }}"
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
                            <span class="text-muted block">
                                @if($auth->hasRole('admin'))
                                    Administrateur
                                @elseif($auth->hasRole('user'))
                                    Utilisateur
                                @elseif($auth->hasRole('ce'))
                                    CE
                                @endif
                                <b class="caret"></b>
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="{{ route('user.show', $auth->id) }}">Mon profil</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('auth/logout') }}">Se déconnecter</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    <img src="{{ asset('img/logoWhite.png') }}"
                         class="img-circle" alt="logo" width="40" height="40"/>
                </div>
            </li>

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('administration*')? 'active' : '' }}">
                    <a href="{{ route('administration.index') }}">
                        <i class="fa fa-lock text-danger"></i>
                        <span class="nav-label text-danger">Administration</span>
                    </a>
                </li>
            @endif

            @if(! $auth->hasRole('ce'))
                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home.index') }}">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">Accueil</span>
                    </a>
                </li>
            @endif

            @if(! $auth->hasRole('ce'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure'))
                    <li class="{{ Request::is('dashboard*')? 'active' : '' }}">
                        <a href="{{ route('dashboard.index') }}">
                            <i class="fa fa-dashboard"></i>
                            <span class="nav-label">Tableau de bord</span>
                        </a>
                    </li>
                @endif
            @endif

            @if(! $auth->hasRole('ce'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure'))
                    <li class="{{ Request::is('stat*')? 'active' : '' }}">
                        <a href="{{ route('stat.show', $auth) }}">
                            <i class="fa fa-area-chart"></i>
                            <span class="nav-label">Statistiques</span>
                        </a>
                    </li>
                @endif
            @endif

            @if(!$auth->hasRole('ce'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure') || $myPlayer == null)
                    <li class="{{ Request::is('championship/index') ? 'active' : '' }}"><a
                                href="{{ route('championship.index') }}"><i class="fa fa-trophy"></i>Championnat</a></li>
                    </li>
                @endif
            @endif

            @if(!$auth->hasRole('ce'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure') || $myPlayer == null)
                    <li class="{{ Request::is('tournament/index') ? 'active' : '' }}"><a
                                href="{{ route('tournament.index') }}"><i class="fa fa-cubes"></i>Tournoi</a></li>
                    </li>
                @endif
            @endif

            @if(!$auth->hasRole('ce'))
                <li class="{{ Request::is('player/create') ? 'active' : '' }}">
                    <a href="{{ route('player.create') }}">
                        <i class="fa fa-ticket"></i>
                        <span class="nav-label">S'inscrire</span>
                    </a>
                </li>
            @endif

            @if(!$auth->hasRole('ce'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure'))
                    <li class="{{ Request::is('reservation/index') || Request::is('playerReservation*') ? 'active' : '' }}">
                        <a href="{{ route('reservation.index') }}">
                            <i class="fa fa-calendar"></i>
                            <span class="nav-label">Réservation</span>
                        </a>
                    </li>
                @endif
            @endif

            @if(!$auth->hasRole('ce'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure'))
                    <li class="{{ Request::is('availability*') ? 'active' : '' }}">
                        <a href="{{ route('availability.index','all') }}">
                            <i class="fa fa-users"></i>
                            <span class="nav-label">Disponibilités</span>
                        </a>
                    </li>
                @endif
            @endif

            @if($auth->hasRole('ce'))
                <li class="{{ Request::is('ce') ? 'active' : '' }}">
                    <a href="{{ route('ce.index') }}">
                        <i class="fa fa-money"></i>
                        <span class="nav-label">Budget</span>
                    </a>
                </li>
            @endif

            @if(!$auth->hasRole('ce'))
                <li class="{{ Request::is('rope') ? 'active' : '' }}">
                    <a href="{{ route('rope.index') }}">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="nav-label">Cordage</span>
                    </a>
                </li>
            @endif

            @if($auth)
                <li class="{{ Request::is('emailToDev') ? 'active' : '' }}">
                    <a href="{{ route('emailToDev.index') }}">
                        <i class="fa fa-send"></i>
                        <span class="nav-label">Email au développeur</span>
                    </a>
                </li>
            @endif

            @if($auth)
                <li class="{{ Request::is('emailToDev') ? 'active' : '' }}">
                    <a href="http://aslectra.com/documents/Presentation%20Badminton.pdf">
                        <i class="fa fa-university"></i>
                        <span class="nav-label">Informations</span>
                    </a>
                </li>
            @endif

        </ul>
        <p class="text-center">&copy; <a href="http://maxime.maheo.free.fr">Maxime Maheo</a></p>
    </div>
</nav>
