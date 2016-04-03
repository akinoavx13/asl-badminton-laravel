<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1 class="text-center">Création d'un tournoi</h1>
    </div>
    <div class="ibox-content">
        {!! Form::open(['route' => 'series.store', 'class' => 'form-horizontal']) !!}

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        @foreach($tournament->series as $series)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="text-center">
                        Série n° {{ $series->display_order }}
                    </h2>
                </div>

                <div class="panel-body">

                    <div class="form-group">
                        <div class="col-md-3">
                            {!! Form::label('category[' . $series->id .']', 'Catégorie :', ['class' => 'control-label']) !!}
                            <i class="text-navy">*</i>
                        </div>

                        <div class="col-md-9">
                            {!! Form::select('category[' . $series->id .']', ['S' => 'S', 'SH' => 'SH', 'SD' => 'SD', 'D' => 'D', 'DH' => 'DH', 'DD' => 'DD', 'M' => 'M'], $series->exists ? $series->category : old('category[' . $series->id .']'),['class' => 'form-control chosen-select', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            {!! Form::label('display_order[' . $series->id .']', 'Ordre d\'affichage :', ['class' => 'control-label']) !!}
                            <i class="text-navy">*</i>
                        </div>

                        <div class="col-md-9">
                            {!! Form::number('display_order[' . $series->id .']', $series->exists ? $series->display_order : old('display_order[' . $series->id .']'),['class' => 'form-control', 'required', 'min' => 1, 'max' => count($tournament->series)]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            {!! Form::label('name[' . $series->id .']', 'Nom :', ['class' => 'control-label']) !!}
                            <i class="text-navy">*</i>
                        </div>

                        <div class="col-md-9">
                            {!! Form::text('name[' . $series->id .']', $series->exists ? $series->name : old('name[' . $series->id .']'),['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            {!! Form::label('number_matches_rank_1[' . $series->id .']', 'Nombre de match de rang 1 :',
                            ['class' => 'control-label']) !!}
                            <i class="text-navy">*</i>
                        </div>

                        <div class="col-md-9">
                            {!! Form::number('number_matches_rank_1[' . $series->id .']', $series->exists ? $series->number_matches_rank_1 : old('number_matches_rank_1[' . $series->id .']'),['class' => 'form-control', 'required', 'min' => 1]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            {!! Form::label('number_rank[' . $series->id .']', 'Nombre de rang :', ['class' => 'control-label']) !!}
                            <i class="text-navy">*</i>
                        </div>

                        <div class="col-md-9">
                            {!! Form::number('number_rank[' . $series->id .']', $series->exists ? $series->number_rank : old('number_rank[' . $series->id .']'),['class' => 'form-control', 'required', 'min' => 1]) !!}
                        </div>
                    </div>

                </div>

            </div>
        @endforeach

        <div class="form-group text-center">
            {!! Form::submit('Suivant', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>

@section('javascript')
    <script>
        $(".chosen-select").chosen();
    </script>
@endsection