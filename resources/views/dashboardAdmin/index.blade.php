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
                                {{ count($users['nbUsersFirstConnection']) }} utilisateurs n'ont pas encore validé la création
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
                                    <tr class="text-center">
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

                                    <tr class="text-center">
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

                                    <tr class="text-center">
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
                                    <h1 class="text-center">
                                        Non lectra
                                        <a href="mailto:@foreach($users['usersChild'] as $user){{ $user->email}};@endforeach @foreach($users['usersConjoint'] as $user){{ $user->email}};@endforeach @foreach($users['usersExternal'] as $user){{ $user->email}};@endforeach @foreach($users['usersTrainee'] as $user){{ $user->email}};@endforeach @foreach($users['usersSubcontractor'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h1>
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
                                    <h1 class="text-center">
                                        Non valide
                                        <a href="mailto:@foreach($users['nbUsersFirstConnection'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h1>
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
                                    <h1 class="text-center">
                                        Inactif
                                        <a href="mailto:@foreach($users['usersHurt'] as $user){{ $user->email}};@endforeach @foreach($users['usersHoliday'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h1>
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
                                    <h1 class="text-center">
                                        Non inscrit
                                        <a href="mailto:@foreach($users['nbUsersNonInscrit'] as $user){{ $user->email}};@endforeach ?Subject=Badminton"
                                           target="_top"> <i class="fa fa-send"></i></a>
                                    </h1>
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

@stop