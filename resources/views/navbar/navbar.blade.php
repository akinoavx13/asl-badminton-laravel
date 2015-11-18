<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <div class="text-center">
                        <span>

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
                                    @if($auth->role === "admin")
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
                            <a href="">Mon profil</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="">Se déconnecter</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="nav-label">Accueil</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Utilisateurs</span>
                </a>
            </li>

        </ul>
    </div>
</nav>