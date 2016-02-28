@extends('emails.layout')

@section('title')
    Inscription à une formule
@stop

@section('content')
    <p>Bonjour {{ $adminUserName }},</p>
    <br>

    <p>
        Nous vous informons que {{ $userName }} s'est inscrit dans une formule.
    </p>

    <table class="table table-bordered table-striped reservation">
        <thead>
        <tr>
            <th class="text-center">Nom</th>
            <th class="text-center">Valeurs</th>
        </tr>
        </thead>

        <tbody>
            @foreach($newValues as $index => $newValue)
                <tr class="text-center">
                    <td>{{ $index }}</td>
                    <td>
                        @if($newValue === true)
                            true
                        @elseif($newValue === false)
                            false
                        @else
                            {{ $newValue }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop