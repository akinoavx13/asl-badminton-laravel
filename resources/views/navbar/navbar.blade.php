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

            @if($auth->hasRole('user') || $auth->hasRole('admin'))

                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home.index') }}">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">Accueil</span>
                    </a>
                </li>

                @if($auth->hasRole('admin'))

                    <li class="{{ Request::is('setting*') || Request::is('court*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa fa-cogs"></i>
                            <span class="nav-label">Paramètres</span>
                            <span class="fa arrow"></span>
                        </a>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ route('setting.index') }}"><i class="fa fa-cogs"></i>Global</a>
                            </li>
                            <li>
                                <a href="{{ route('court.index') }}"><i class="fa fa-cogs"></i>Court</a>
                            </li>
                            <li>
                                <a href="{{ route('timeSlot.index') }}"><i class="fa fa-cogs"></i>Créneaux</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('user*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa fa-user"></i>
                            <span class="nav-label">Utilisateurs</span>
                            <span class="fa arrow"></span>
                        </a>

                        <ul class="nav nav-second-level">
                            <li><a href="{{ route('user.index') }}"><i class="fa fa-list"></i>Liste des
                                    utilisateurs</a>
                            </li>
                            <li><a href="{{ route('user.create') }}"><i class="fa fa-user-plus"></i>Créer un
                                    utilisateur</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('player/index') ? 'active' : '' }}">
                        <a href="{{ route('player.index') }}">
                            <i class="fa fa-group"></i>
                            <span class="nav-label">Liste des joueurs</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('season*') ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa fa-star-half-full"></i>
                            <span class="nav-label">Saisons</span>
                            <span class="fa arrow"></span>
                        </a>

                        <ul class="nav nav-second-level">
                            <li><a href="{{ route('season.index') }}"><i class="fa fa-list"></i>Liste des
                                    saisons</a></li>
                            <li><a href="{{ route('season.create') }}"><i class="fa fa-plus"></i>Créer une
                                    saison</a></li>
                        </ul>
                    </li>

                @endif

                <li class="{{ Request::is('player/create') ? 'active' : '' }}">
                    <a href="{{ route('player.create') }}">
                        <i class="fa fa-ticket"></i>
                        <span class="nav-label">S'inscrire à une saison</span>
                    </a>
                </li>
            @endif
            @if($auth->hasRole('ce') || $auth->hasRole('admin'))
                <li class="{{ Request::is('ce') ? 'active' : '' }}">
                    <a href="{{ route('ce.index') }}">
                        <i class="fa fa-money"></i>
                        <span class="nav-label">Budget</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>