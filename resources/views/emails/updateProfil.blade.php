@extends('emails.layout')

@section('title')
    Modification du profil
@stop

@section('content')
    <p>Bonjour {{ $adminUserName }},</p>
    <br>

    <p>
        Nous vous informons que {{ $userName }} a modifié son profil.
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
                
                    @if($oldValues[$index] === true)
                        @if($oldValues[$index] !== $newValue)
                            <td style="background-color: #4CAF50;color: white;font-weight: bold;">true
                        @else
                            <td>true
                        @endif
                    @elseif($oldValues[$index] === false)
                        @if($oldValues[$index] !== $newValue)
                            <td style="background-color: #4CAF50;color: white;font-weight: bold;">false
                        @else
                            <td>false
                        @endif
                    @elseif($oldValues[$index] === null)
                        @if($oldValues[$index] !== $newValue)
                            <td style="background-color: #4CAF50;color: white;font-weight: bold;">null
                        @else
                            <td>null
                        @endif
                    @else
                        @if($oldValues[$index] !== $newValue)
                            <td style="background-color: #4CAF50;color: white;font-weight: bold;">{{ $oldValues[$index] }}
                        @else
                            <td>{{ $oldValues[$index] }}
                        @endif
                    @endif
                </td>
                
                    @if($newValue === true)
                        @if($oldValues[$index] !== $newValue)
                            <td style="background-color: #4CAF50;color: white;font-weight: bold;">true
                        @else
                            <td>true
                        @endif
                    @elseif($newValue === false)
                        @if($oldValues[$index] !== $newValue)
                            <td style="background-color: #4CAF50;color: white;font-weight: bold;">false
                        @else
                            <td>false
                        @endif
                    @elseif($newValue === null)
                        @if($oldValues[$index] !== $newValue)
                            <td style="background-color: #4CAF50;color: white;font-weight: bold;">null
                        @else
                            <td>null
                        @endif
                    @else
                        @if($oldValues[$index] !== $newValue)
                            <td style="background-color: #4CAF50;color: white;font-weight: bold;">{{ $newValue }}
                        @else
                            <td>{{ $newValue }}
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop