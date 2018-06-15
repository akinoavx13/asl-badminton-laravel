@extends('emails.layout')

@section('title')
    Inscription à la section Badminton
@stop

@section('content')
    <p>Bonjour {{ $forname }} {{ $name }},</p>
    <br>

    <p>
        Nous vous informons que votre inscription à la section badminton a bien été enregistré.</br>
        <strong style="color:red;">Si ce n'est pas déjà le cas, merci de faire votre inscription sur le site du CE afin de payer votre cotisation.</strong>
    </p>

    
@stop