@extends('layout')

@section('title')
    Administration
@stop

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Tableau de bord</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('dashboardAdmin.index') }}" class="btn btn-success btn-outline btn-block"><i class="fa fa-dashboard"></i> Section</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Paramètres</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('setting.index') }}" class="btn btn-primary btn-outline btn-block"><i class="fa fa-cogs"></i> Global</a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('court.index') }}" class="btn btn-success btn-outline btn-block"><i class="fa fa-cogs"></i> Court</a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('timeSlot.index') }}" class="btn btn-danger btn-outline btn-block"><i class="fa fa-cogs"></i> Crénaux</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Utilisateurs</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('user.index') }}" class="btn btn-primary btn-outline btn-block"><i class="fa fa-list"></i> Lister</a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('user.create') }}" class="btn btn-success btn-outline btn-block"><i class="fa fa-user-plus"></i> Créer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Joueurs</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('player.index') }}" class="btn btn-primary btn-outline btn-block"><i class="fa fa-list"></i> Lister</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Saisons</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('season.index') }}" class="btn btn-primary btn-outline btn-block"><i class="fa fa-list"></i> Lister</a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('season.create') }}" class="btn btn-success btn-outline btn-block"><i class="fa fa-plus"></i> Créer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Championnat</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('championship.create') }}" class="btn btn-success btn-outline btn-block"><i class="fa fa-plus"></i> Créer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Tournoi</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('tournament.create') }}" class="btn btn-success btn-outline btn-block"><i class="fa fa-plus"></i> Créer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Réservations</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('adminReservation.create') }}" class="btn btn-danger btn-outline btn-block"><i class="fa fa-times"></i> Bloquer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Budget</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('ce.index') }}" class="btn btn-danger btn-outline btn-block"><i class="fa fa-eye"></i> Voir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Cordage</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('rope.create') }}" class="btn btn-success btn-outline btn-block"><i class="fa fa-plus"></i> Créer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop