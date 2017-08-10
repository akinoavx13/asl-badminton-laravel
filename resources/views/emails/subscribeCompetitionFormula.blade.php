@extends('emails.layout')

@section('title')
    Inscription formule compétition
@stop

@section('content')
    <p>Bonjour {{ $forname }} {{ $name }},</p>
    <br>

    <p>
        Nous vous informons que votre inscription à la formule compétition à bien été enregistré.
    </p>

    <p>
        Pour finaliser votre inscription, merci de bien vouloir remplir les formulaires ci-dessous et les transmettre le
        plus tôt possible à Christophe Mahéo
    </p>

    <ul>
        <li>
            <p>
                Si il s’agit de votre première demande de licence il faut remplir le <a href="{{ asset('documents/certificat_medical.pdf') }}">certificat médical</a>
                et la
                <a href="{{ asset('documents/formulaire_licence.pdf') }}">demande de licence</a>.
            </p>
        </li>
        <li>
            <p>
                Si il s’agit d’un renouvellement de licence et que le certificat médical fournit l’année dernière était
                daté à partir du 1er Juillet 2016, il faut remplir la <a href="{{ asset('documents/formulaire_licence.pdf') }}">demande de licence</a> et vous pouvez éviter le
                certificat médical et ne fournir que le <a href="{{ asset('documents/questionnaire_sante.pdf') }}">questionnaire de santé</a> (sous réserve que vous répondrez NON à
                toutes les questions, sinon il faudra tout de même un <a href="{{ asset('documents/certificat_medical.pdf') }}">certificat médical</a>)
            </p>
        </li>
    </ul>
@stop