@extends('emails.layout')

@section('title')
    Modification de l'inscription
@stop

@section('content')
    <p>Bonjour {{ $adminUserName }},</p>
    <br>

    <p>
        Nous vous informons que {{ $userName }} a modifié son inscription.
    </p>

    <table class="table table-bordered table-striped reservation">
        <thead>
        <tr>
            <th class="text-center">Nom</th>
            <th class="text-center">Ancienne valeur</th>
            <th class="text-center">Nouvelle valeur</th>
        </tr>
        </thead>

        <tbody>
        @foreach($newValues as $index => $newValue)
            <tr class="text-center">
                <td>{{ $index }}</td>
                <td>
                    @if($oldValues[$index] === true)
                        @if($oldValues[$index] !== $newValue)
                            <span class="text-danger">true</span>
                        @else
                            true
                        @endif
                    @elseif($oldValues[$index] === false)
                        @if($oldValues[$index] !== $newValue)
                            <span class="text-danger">false</span>
                        @else
                            false
                        @endif
                    @elseif($oldValues[$index] === null)
                        @if($oldValues[$index] !== $newValue)
                            <span class="text-danger">null</span>
                        @else
                            null
                        @endif
                    @else
                        @if($oldValues[$index] !== $newValue)
                            <span class="text-danger">{{ $oldValues[$index] }}</span>
                        @else
                            {{ $oldValues[$index] }}
                        @endif
                    @endif
                </td>
                <td>
                    @if($newValue === true)
                        @if($oldValues[$index] !== $newValue)
                            <span class="text-danger">true</span>
                        @else
                            true
                        @endif
                    @elseif($newValue === false)
                        @if($oldValues[$index] !== $newValue)
                            <span class="text-danger">false</span>
                        @else
                            false
                        @endif
                    @elseif($newValue === null)
                        @if($oldValues[$index] !== $newValue)
                            <span class="text-danger">null</span>
                        @else
                            null
                        @endif
                    @else
                        @if($oldValues[$index] !== $newValue)
                            <span class="text-danger">{{ $newValue }}</span>
                        @else
                            {{ $newValue }}
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop