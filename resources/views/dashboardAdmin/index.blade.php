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
                                {{ $users['nbUsersFirstConnection'] }} utilisateurs n'ont pas encore validé la création
                                du compte
                            </div>
                            <div class="alert alert-warning text-center">
                                {{ $users['nbUsersInvalid'] }} utilisateurs valides non inscrits
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
                                            <a href="mailto:@foreach($users['users'] as $user){{ $user->email}};@endforeach ?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary m-r-sm">
                                                {{ count($users['usersMan']) }}
                                            </button>
                                            Hommes
                                            <a href="mailto:@foreach($users['usersMan'] as $user){{$user->email}};@endforeach ?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($users['usersWoman']) }}
                                            </button>
                                            Femmes
                                            <a href="mailto:@foreach($users['usersWoman'] as $user){{ $user->email}};@endforeach ?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>

                                    <tr class="text-center">
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($users['usersLectra']) }}
                                            </button>
                                            Lectra
                                            <a href="mailto:@foreach($users['usersLectra'] as $user){{ $user->email}};@endforeach?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success m-r-sm">
                                                {{ count($users['usersChild']) }}
                                            </button>
                                            Enfant
                                            <a href="mailto:@foreach($users['usersChild'] as $user){{ $user->email}};@endforeach ?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($users['usersConjoint']) }}
                                            </button>
                                            Conjoint
                                            <a href="mailto:@foreach($users['usersConjoint'] as $user){{ $user->email}};@endforeach ?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>

                                    <tr class="text-center">
                                        <td>
                                            <button type="button" class="btn btn-warning m-r-sm">
                                                {{ count($users['usersExternal']) }}
                                            </button>
                                            Externe
                                            <a href="mailto:@foreach($users['usersExternal'] as $user){{ $user->email}};@endforeach ?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info m-r-sm">
                                                {{ count($users['usersTrainee']) }}
                                            </button>
                                            Stagiaire
                                            <a href="mailto:@foreach($users['usersTrainee'] as $user){{ $user->email}};@endforeach ?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger m-r-sm">
                                                {{ count($users['usersSubcontractor']) }}
                                            </button>
                                            Sous traitant
                                            <a href="mailto:@foreach($users['usersSubcontractor'] as $user){{ $user->email}};@endforeach ?Subject=Badminton" target="_top"> <i class="fa fa-send"></i></a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop