@extends('layout')

@section('title')
    Tableau de bord de la section
@stop

@section('content')

    <h1 class="text-center">Tableau de bord</h1>
    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h1 class="text-center">
                        Utilisateurs
                    </h1>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger text-center">
                                {{ count($users['nbUsersFirstConnection']) }} utilisateurs n'ont pas encore validé la
                                création
                                du compte
                            </div>
                            <div class="alert alert-warning text-center">
                                {{ count($users['nbUsersInvalid']) }} utilisateurs valides non inscrits
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($users['users']) }}
                                            </button>
                                            Utilisateurs
                                            <a href="mailto:@foreach($users['users'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary m-r-sm">
                                                {{ count($users['usersMan']) }}
                                            </button>
                                            Hommes
                                            <a href="mailto:@foreach($users['usersMan'] as $user){{$user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($users['usersWoman']) }}
                                            </button>
                                            Femmes
                                            <a href="mailto:@foreach($users['usersWoman'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($users['usersLectra']) }}
                                            </button>
                                            Lectra
                                            <a href="mailto:@foreach($users['usersLectra'] as $user){{ $user->email}};@endforeach?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success m-r-sm">
                                                {{ count($users['usersChild']) }}
                                            </button>
                                            Enfant
                                            <a href="mailto:@foreach($users['usersChild'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($users['usersConjoint']) }}
                                            </button>
                                            Conjoint
                                            <a href="mailto:@foreach($users['usersConjoint'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-warning m-r-sm">
                                                {{ count($users['usersExternal']) }}
                                            </button>
                                            Externe
                                            <a href="mailto:@foreach($users['usersExternal'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($users['usersTrainee']) }}
                                            </button>
                                            Stagiaire
                                            <a href="mailto:@foreach($users['usersTrainee'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($users['usersSubcontractor']) }}
                                            </button>
                                            Sous traitant
                                            <a href="mailto:@foreach($users['usersSubcontractor'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="text-center text-danger">
                                {{ count($users['usersHurt']) }} blessés
                            </h1>
                        </div>
                        <div class="col-md-6">
                            <h1 class="text-center text-danger">
                                {{ count($users['usersHoliday']) }} en vacances
                            </h1>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Non lectra
                                        <a href="mailto:@foreach($users['usersChild'] as $user){{ $user->email}};@endforeach @foreach($users['usersConjoint'] as $user){{ $user->email}};@endforeach @foreach($users['usersExternal'] as $user){{ $user->email}};@endforeach @foreach($users['usersTrainee'] as $user){{ $user->email}};@endforeach @foreach($users['usersSubcontractor'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($users['usersChild']) > 0)
                                        <h2 class="text-center text-danger">
                                            Enfant
                                            <a href="mailto:@foreach($users['usersChild'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($users['usersChild'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                            </p>
                                        @endforeach
                                    @endif
                                    @if(count($users['usersConjoint']) > 0)
                                        <h2 class="text-center text-danger">
                                            Conjoint
                                            <a href="mailto:@foreach($users['usersConjoint'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($users['usersConjoint'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                            </p>
                                        @endforeach
                                    @endif
                                    @if(count($users['usersExternal']) > 0)
                                        <h2 class="text-center  text-danger">
                                            Externe
                                            <a href="mailto:@foreach($users['usersExternal'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($users['usersExternal'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                            </p>
                                        @endforeach
                                    @endif
                                    @if(count($users['usersTrainee']) > 0)
                                        <h2 class="text-center text-danger">
                                            Stagiaire
                                            <a href="mailto:@foreach($users['usersTrainee'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($users['usersTrainee'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                            </p>
                                        @endforeach
                                    @endif
                                    @if(count($users['usersSubcontractor']) > 0)
                                        <h2 class="text-center text-danger">
                                            Stagiaire
                                            <a href="mailto:@foreach($users['usersSubcontractor'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($users['usersSubcontractor'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                            </p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Non valide
                                        <a href="mailto:@foreach($users['nbUsersFirstConnection'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($users['nbUsersFirstConnection']) > 0)
                                        @foreach($users['nbUsersFirstConnection'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-center text-success">
                                            Tous les utilisateurs ont validés leur compte !
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Inactif
                                        <a href="mailto:@foreach($users['usersHurt'] as $user){{ $user->email}};@endforeach @foreach($users['usersHoliday'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($users['usersHurt']) > 0)
                                        <h2 class="text-center text-danger">
                                            Blessés
                                            <a href="mailto:@foreach($users['usersHurt'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($users['usersHurt'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                                <span class="text-danger">
                                                    ({{ $user->ending_injury }})
                                                </span>
                                            </p>
                                        @endforeach
                                    @endif
                                    @if(count($users['usersHoliday']) > 0)
                                        <h2 class="text-center text-danger">
                                            Conjoint
                                            <a href="mailto:@foreach($users['usersHoliday'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($users['usersHoliday'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                                <span class="text-danger">
                                                    ({{ $user->ending_holiday }})
                                                </span>
                                            </p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Non inscrit
                                        <a href="mailto:@foreach($users['nbUsersNonInscrit'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($users['nbUsersNonInscrit']) > 0)
                                        @foreach($users['nbUsersNonInscrit'] as $user)
                                            <p class="text-center">
                                                {{ $user }}
                                            </p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h1 class="text-center">
                        Joueurs sur la saison active ({{ $activeSeason }})
                    </h1>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger text-center">
                                {{ count($players['contribution_payable']) }} cotisation à payer
                            </div>
                            <div class="alert alert-warning text-center">
                                {{ count($players['entry_must']) }} dossier à remettre à GBC
                            </div>
                            <div class="alert alert-info text-center">
                                {{ count($players['t_shirt']) }} t-shirt à commander
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($players['players']) }}
                                            </button>
                                            Joueurs
                                            <a href="mailto:@foreach($players['players'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary m-r-sm">
                                                {{ count($players['leisure']) }}
                                            </button>
                                            Loisir
                                            <a href="mailto:@foreach($players['leisure'] as $player){{$player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($players['fun']) }}
                                            </button>
                                            Fun
                                            <a href="mailto:@foreach($players['fun'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($players['performance']) }}
                                            </button>
                                            Performance
                                            <a href="mailto:@foreach($players['performance'] as $player){{ $player->email}};@endforeach?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success m-r-sm">
                                                {{ count($players['corpo']) }}
                                            </button>
                                            Corpo
                                            <a href="mailto:@foreach($players['corpo'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($players['competition']) }}
                                            </button>
                                            Compétition
                                            <a href="mailto:@foreach($players['competition'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($players['corpo_man']) }}
                                            </button>
                                            Corpo homme
                                            <a href="mailto:@foreach($players['corpo_man'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning m-r-sm">
                                                {{ count($players['corpo_woman']) }}
                                            </button>
                                            Corpo femme
                                            <a href="mailto:@foreach($players['corpo_woman'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($players['corpo_mixte']) }}
                                            </button>
                                            Corpo mixte
                                            <a href="mailto:@foreach($players['corpo_mixte'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Cotisation à payer
                                        <a href="mailto:@foreach($players['contribution_payable'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($players['contribution_payable']) > 0)
                                        @foreach($players['contribution_payable'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-center text-success">
                                            Tous le monde à payé !
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Dossier à remettre à GBC
                                        <a href="mailto:@foreach($players['entry_must'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($players['entry_must']) > 0)
                                        @foreach($players['entry_must'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-center text-success">
                                            Tous les dossier GBC sont donnés !
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        T-Shirt
                                        <a href="mailto:@foreach($players['t_shirt'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"><i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($players['t_shirt_man']) > 0)
                                        <h2 class="text-center">
                                            Homme
                                            <a href="mailto:@foreach($players['t_shirt_man'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"><i class="fa fa-send"></i></a>
                                        </h2>
                                        @if(count($players['t_shirt_man_xxs']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_man_xxs']) }} taille XXS
                                                <a href="mailto:@foreach($players['t_shirt_man_xxs'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_man_xs']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_man_xs']) }} taille XS
                                                <a href="mailto:@foreach($players['t_shirt_man_xs'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_man_s']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_man_s']) }} taille S
                                                <a href="mailto:@foreach($players['t_shirt_man_s'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_man_m']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_man_m']) }} taille M
                                                <a href="mailto:@foreach($players['t_shirt_man_m'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_man_l']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_man_l']) }} taille L
                                                <a href="mailto:@foreach($players['t_shirt_man_l'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_man_xl']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_man_xl']) }} taille XL
                                                <a href="mailto:@foreach($players['t_shirt_man_xl'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_man_xxl']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_man_xxl']) }} taille XXL
                                                <a href="mailto:@foreach($players['t_shirt_woman_xxl'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                    @endif
                                    @if(count($players['t_shirt_woman']) > 0)
                                        <h2 class="text-center">
                                            Femme
                                            <a href="mailto:@foreach($players['t_shirt_woman'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"><i class="fa fa-send"></i></a>
                                        </h2>
                                        @if(count($players['t_shirt_woman_xxs']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_woman_xxs']) }} taille XXS
                                                <a href="mailto:@foreach($players['t_shirt_woman_xxs'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_woman_xs']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_woman_xs']) }} taille XS
                                                <a href="mailto:@foreach($players['t_shirt_woman_xs'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_woman_s']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_woman_s']) }} taille S
                                                <a href="mailto:@foreach($players['t_shirt_woman_s'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_woman_m']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_woman_m']) }} taille M
                                                <a href="mailto:@foreach($players['t_shirt_woman_m'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_woman_l']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_woman_l']) }} taille L
                                                <a href="mailto:@foreach($players['t_shirt_woman_l'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_woman_xl']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_woman_xl']) }} taille XL
                                                <a href="mailto:@foreach($players['t_shirt_woman_xl'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                        @if(count($players['t_shirt_woman_xxl']) > 0)
                                            <p class="text-center">
                                                {{ count($players['t_shirt_woman_xxl']) }} taille XXL
                                                <a href="mailto:@foreach($players['t_shirt_woman_xxl'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                                   target="_top"><i class="fa fa-send"></i></a>
                                            </p>
                                        @endif
                                    @endif
                                    @if(count($players['t_shirt_corpo_competition']) > 0)
                                        <h2 class="text-center">
                                            Corpo et compétition
                                            <a href="mailto:@foreach($players['t_shirt_corpo_competition'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"><i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($players['t_shirt_corpo_competition'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                                <strong>
                                                    (taille {{ $player->tshirt_size }})
                                                </strong>
                                            </p>
                                        @endforeach
                                    @endif
                                    @if(count($players['t_shirt_buy']) > 0)
                                        <h2 class="text-center">
                                            Acheté via l'option
                                            <a href="mailto:@foreach($players['t_shirt_buy'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"><i class="fa fa-send"></i></a>
                                        </h2>
                                        @foreach($players['t_shirt_buy'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                                <strong>
                                                    (taille {{ $player->tshirt_size }})
                                                </strong>
                                            </p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Corpo
                                        <a href="mailto:@foreach($players['corpo'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <h2 class="text-center">
                                    Homme
                                    <a href="mailto:@foreach($players['corpo_man'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                       target="_top"> <i class="fa fa-send"></i></a>
                                </h2>
                                <div class="panel-body">
                                    @if(count($players['corpo_man']) > 0)
                                        @foreach($players['corpo_man'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                            </p>
                                        @endforeach
                                    @endif
                                </div>

                                <h2 class="text-center">
                                    Femme
                                    <a href="mailto:@foreach($players['corpo_woman'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                       target="_top"> <i class="fa fa-send"></i></a>
                                </h2>
                                <div class="panel-body">
                                    @if(count($players['corpo_woman']) > 0)
                                        @foreach($players['corpo_woman'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                            </p>
                                        @endforeach
                                    @endif
                                </div>

                                <h2 class="text-center">
                                    Mixte
                                    <a href="mailto:@foreach($players['corpo_mixte'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                       target="_top"> <i class="fa fa-send"></i></a>
                                </h2>
                                <div class="panel-body">
                                    @if(count($players['corpo_mixte']) > 0)
                                        @foreach($players['corpo_mixte'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                            </p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h1 class="text-center">
                        Équipe sur la saison active ({{ $activeSeason }})
                    </h1>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($players['simple']) }}
                                            </button>
                                            Joueurs en simple
                                            <a href="mailto:@foreach($players['simple'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary m-r-sm">
                                                {{ count($players['double']) }}
                                            </button>
                                            Joueurs en double
                                            <a href="mailto:@foreach($players['double'] as $player){{$player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($players['mixte']) }}
                                            </button>
                                            Joueur en mixte
                                            <a href="mailto:@foreach($players['mixte'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                               target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Recherche en double
                                        <a href="mailto:@foreach($players['search_double'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($players['search_double']) > 0)
                                        @foreach($players['search_double'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-center text-success">
                                            Tous le monde a un partenaire !
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Recherche en mixte
                                        <a href="mailto:@foreach($players['search_mixte'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($players['search_mixte']) > 0)
                                        @foreach($players['search_mixte'] as $player)
                                            <p class="text-center">
                                                {{ $player }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-center text-success">
                                            Tous le monde a un partenaire !
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Simple
                                        <a href="mailto:@foreach($players['simple'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($players['simple']) > 0)
                                        @foreach($players['simple'] as $player)
                                            <p class="text-center">
                                                @if($player->avatar)
                                                    <img src="{{ asset('img/avatars/' . $player->user_id . '.jpg') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @else
                                                    <img src="{{ asset('img/anonymous.png') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @endif
                                                {{ $player }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-danger text-success">
                                            Personne en simple
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Double
                                        <a href="mailto:@foreach($players['double'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($players['double']) > 0)
                                        @foreach($players['double'] as $player)
                                            <p class="text-center">
                                                @if($player->userOneAvatar)
                                                    <img src="{{ asset('img/avatars/' . $player->userOneId . '.jpg') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @else
                                                    <img src="{{ asset('img/anonymous.png') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @endif
                                                {{ $player->userOneForname . ' ' . $player->userOneName }} & {{
                                                $player->userTwoForname . ' ' . $player->userTwoName }}
                                                @if($player->userTwoAvatar)
                                                    <img src="{{ asset('img/avatars/' . $player->userTwoId . '.jpg') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @else
                                                    <img src="{{ asset('img/anonymous.png') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @endif
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-danger text-success">
                                            Personne en double
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="text-center">
                                        Mixte
                                        <a href="mailto:@foreach($players['mixte'] as $player){{ $player->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    @if(count($players['mixte']) > 0)
                                        @foreach($players['mixte'] as $player)
                                            <p class="text-center">
                                                @if($player->userOneAvatar)
                                                    <img src="{{ asset('img/avatars/' . $player->userOneId . '.jpg') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @else
                                                    <img src="{{ asset('img/anonymous.png') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @endif
                                                {{ $player->userOneForname . ' ' . $player->userOneName }} & {{
                                                $player->userTwoForname . ' ' . $player->userTwoName }}
                                                @if($player->userTwoAvatar)
                                                    <img src="{{ asset('img/avatars/' . $player->userTwoId . '.jpg') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @else
                                                    <img src="{{ asset('img/anonymous.png') }}"
                                                         alt="logo" width="35" height="35"/>
                                                @endif
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-danger text-success">
                                            Personne en mixte
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop