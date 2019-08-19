@extends('emails.layout')

@section('title')
    Inscription formule compétition
@stop

@section('content')
    <p>Bonjour {{ $forname }} {{ $name }},</p>
    <br>

    <p>
        Nous vous informons que votre inscription à la formule compétition a bien été enregistrée.</br>
        <strong style="color:red;">Si ce n'est pas déjà le cas, merci de faire votre inscription sur le site du CE afin de payer votre cotisation.</strong>
    </p>

    <p>
        Pour finaliser votre inscription, merci de bien vouloir remplir les formulaires ci-dessous et de les transmettre le
        plus tôt possible à Christophe Mahéo.
    </p>

    <ul>
        <li>
            <p>
                S'il s’agit de votre première demande de licence, il faut remplir le <a href="{{ asset('documents/certificat_medical.pdf') }}">certificat médical</a>
                et la
                <a href="{{ asset('documents/formulaire_licence.pdf') }}">demande de licence</a>.
            </p>
        </li>
        <li>
            <p>
                S'il s’agit d’un renouvellement de licence et que le certificat médical fourni l’année dernière a
                moins de 3 ans au 1er Juillet de cette année, il faut remplir la <a href="{{ asset('documents/formulaire_licence.pdf') }}">demande de licence</a> et vous pouvez éviter le
                certificat médical et ne fournir que le <a href="{{ asset('documents/questionnaire_sante.pdf') }}">questionnaire de santé</a> (sous réserve que vous répondrez NON à
                toutes les questions, sinon il faudra tout de même un <a href="{{ asset('documents/certificat_medical.pdf') }}">certificat médical</a>).
            </p>
        </li>
    </ul>
@stop