@extends('layout')

@section('title')
    Créer un championnat
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('championship.form')
        </div>
    </div>
@stop

@section('javascript')
    <script>
        if ($("#simple").length != 0) {
            $('#simple').tabledragdrop({"selector": "#simple"});
        }
        if ($("#simple_man").length != 0) {
            $('#simple_man').tabledragdrop({"selector": "#simple_man"});
        }
        if ($("#simple_woman").length != 0) {
            $('#simple_woman').tabledragdrop({"selector": "#simple_woman"});
        }
        if ($("#double_man").length != 0) {
            $('#double_man').tabledragdrop({"selector": "#double_man"});
        }
        if ($("#double_woman").length != 0) {
            $('#double_woman').tabledragdrop({"selector": "#double_woman"});
        }
        if ($("#double").length != 0) {
            $('#double').tabledragdrop({"selector": "#double"});
        }
        if ($("#mixte").length != 0) {
            $('#mixte').tabledragdrop({"selector": "#mixte"});
        }
    </script>
@stop