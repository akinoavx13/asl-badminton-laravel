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

            @if(! $auth->hasRole('ce'))
                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home.index') }}">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">Accueil</span>
                    </a>
                </li>
            @endif

            @if($auth->hasRole('user'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure'))
                    <li class="{{ Request::is('dashboard*')? 'active' : '' }}">
                        <a href="{{ route('dashboard.index') }}">
                            <i class="fa fa-dashboard"></i>
                            <span class="nav-label">Tableau de bord</span>
                        </a>
                    </li>
                @endif
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-dashboard"></i>
                        <span class="nav-label">Tableau de bord</span>
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('dashboard/index') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Joueur</a>
                        </li>
                        <li class="{{ Request::is('dashboardAdmin/index') ? 'active' : '' }}">
                            <a href="{{ route('dashboardAdmin.index') }}"><i class="fa fa-dashboard"></i>Section</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('setting*') || Request::is('court*') || Request::is('timeSlot*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span class="nav-label">Paramètres</span>
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('setting/index') ? 'active' : '' }}">
                            <a href="{{ route('setting.index') }}"><i class="fa fa-cogs"></i>Global</a>
                        </li>
                        <li class="{{ Request::is('court/index') ? 'active' : '' }}">
                            <a href="{{ route('court.index') }}"><i class="fa fa-cogs"></i>Court</a>
                        </li>
                        <li class="{{ Request::is('timeSlot/index') ? 'active' : '' }}">
                            <a href="{{ route('timeSlot.index') }}"><i class="fa fa-cogs"></i>Créneaux</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('user*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span class="nav-label">Utilisateurs</span>
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('user/index') ? 'active' : '' }}"><a
                                    href="{{ route('user.index') }}"><i class="fa fa-list"></i>Liste des
                                utilisateurs</a>
                        </li>
                        <li class="{{ Request::is('user/create') ? 'active' : '' }}"><a
                                    href="{{ route('user.create') }}"><i class="fa fa-user-plus"></i>Créer un
                                utilisateur</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('player/index') ? 'active' : '' }}">
                    <a href="{{ route('player.index') }}">
                        <i class="fa fa-group"></i>
                        <span class="nav-label">Liste des joueurs</span>
                    </a>
                </li>
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('season*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-star-half-full"></i>
                        <span class="nav-label">Saisons</span>
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('season/index') ? 'active' : '' }}"><a
                                    href="{{ route('season.index') }}"><i class="fa fa-list"></i>Liste des
                                saisons</a></li>
                        <li class="{{ Request::is('season/create') ? 'active' : '' }}"><a
                                    href="{{ route('season.create') }}"><i class="fa fa-plus"></i>Créer une
                                saison</a></li>
                    </ul>
                </li>
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('championship*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-trophy"></i>
                        <span class="nav-label">Championnat</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('championship/create') ? 'active' : '' }}"><a
                                    href="{{ route('championship.create') }}"><i class="fa fa-plus"></i>Créer un
                                championnat</a></li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('championship/index') ? 'active' : '' }}"><a
                                    href="{{ route('championship.index') }}"><i class="fa fa-eye"></i>Voir le classement
                                du championnat</a></li>
                    </ul>
                </li>
            @endif

            @if($auth->hasRole('user'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure') || $myPlayer == null)
                    <li class="{{ Request::is('championship/index') ? 'active' : '' }}"><a
                                href="{{ route('championship.index') }}"><i class="fa fa-eye"></i>Voir le classement du
                            championnat</a></li>
                    </li>
                @endif
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('tournament*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-trophy"></i>
                        <span class="nav-label">Tournoi</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('tournament/create') ? 'active' : '' }}"><a
                                    href="{{ route('tournament.create') }}"><i class="fa fa-plus"></i>Créer un
                                tournoi</a></li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('tournament/index') ? 'active' : '' }}"><a
                                    href="{{ route('tournament.index') }}"><i class="fa fa-eye"></i>Voir le classement
                                du tournoi</a></li>
                    </ul>
                </li>
            @endif

            @if($auth->hasRole('user'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure') || $myPlayer == null)
                    <li class="{{ Request::is('tournament/index') ? 'active' : '' }}"><a
                                href="{{ route('tournament.index') }}"><i class="fa fa-eye"></i>Voir le classement du
                            tournoi</a></li>
                    </li>
                @endif
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('reservation/index') || Request::is('playerReservation*') || Request::is('adminReservation/create') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-calendar"></i>
                        <span class="nav-label">Réservation</span>
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('reservation/index') ? 'active' : '' }}"><a
                                    href="{{ route('reservation.index') }}"><i class="fa fa-plus"></i>Réserver
                                un terrain</a>
                        </li>
                        <li class="{{ Request::is('adminReservation/create') ? 'active' : '' }}"><a
                                    href="{{ route('adminReservation.create') }}"><i class="fa
                                        fa-times"></i>Bloquer une réservation</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if($auth->hasRole('user') || $auth->hasRole('admin'))
                <li class="{{ Request::is('player/create') ? 'active' : '' }}">
                    <a href="{{ route('player.create') }}">
                        <i class="fa fa-ticket"></i>
                        <span class="nav-label">S'inscrire à une saison</span>
                    </a>
                </li>
            @endif

            @if($auth->hasRole('user'))
                @if($myPlayer !== null && ! $myPlayer->hasFormula('leisure'))
                    <li class="{{ Request::is('reservation/index') || Request::is('playerReservation*') ? 'active' : '' }}">
                        <a href="{{ route('reservation.index') }}">
                            <i class="fa fa-calendar"></i>
                            <span class="nav-label">Réservation</span>
                        </a>
                    </li>
                @endif
            @endif

            @if($auth->hasRole('user') || $auth->hasRole('admin'))
                <li class="{{ Request::is('testimonial/index') ? 'active' : '' }}">
                    <a href="{{ route('testimonial.index') }}">
                        <i class="fa fa-bookmark"></i>
                        <span class="nav-label">Témoignages</span>
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

            @if($auth->hasRole('user'))
                <li class="{{ Request::is('rope') ? 'active' : '' }}">
                    <a href="{{ route('rope.index') }}">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="nav-label">Cordage</span>
                    </a>
                </li>
            @endif

            @if($auth->hasRole('admin'))
                <li class="{{ Request::is('rope*')  ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="nav-label">Cordage</span>
                        <span class="fa arrow"></span>
                    </a>

                    <ul class="nav nav-second-level">
                        <li class="{{ Request::is('rope/index') ? 'active' : '' }}"><a
                                    href="{{ route('rope.index') }}"><i class="fa fa-shopping-cart"></i>Recorder</a>
                        </li>
                        <li class="{{ Request::is('rope/create') ? 'active' : '' }}"><a
                                    href="{{ route('rope.create') }}"><i class="fa
                                        fa-plus"></i>Ajouter une bobine</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if($auth->hasRole('user') || $auth->hasRole('ce') || $auth->hasRole('admin'))
                <li class="{{ Request::is('emailToDev') ? 'active' : '' }}">
                    <a href="{{ route('emailToDev.index') }}">
                        <i class="fa fa-send"></i>
                        <span class="nav-label">Email au développeur</span>
                    </a>
                </li>
            @endif

            @if($auth->hasRole('admin'))
                <li class="">
                    <a href="http://badminton.api.aslectra.com/">
                        <i class="fa fa-key"></i>
                        <span class="nav-label">Lectra API</span>
                    </a>
                </li>
            @endif

        </ul>
        <p class="text-center">&copy; <a href="http://maxime.maheo.free.fr">Maxime Maheo</a></p>
    </div>
</nav>