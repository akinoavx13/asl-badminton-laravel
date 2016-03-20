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
            RowSorter("#simple");
        }
        if ($("#simple_man").length != 0) {
            RowSorter("#simple_man");
        }
        if ($("#simple_woman").length != 0) {
            RowSorter("#simple_woman");
        }
        if ($("#double_man").length != 0) {
            RowSorter("#double_man");
        }
        if ($("#double_woman").length != 0) {
            RowSorter("#double_woman");
        }
        if ($("#double").length != 0) {
            RowSorter("#double");
        }
        if ($("#mixte").length != 0) {
            RowSorter("#mixte");
        }
    </script>
@stop