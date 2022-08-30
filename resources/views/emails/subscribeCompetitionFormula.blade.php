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
        <strong style="color:red;">Pour finaliser votre inscription, merci de bien vouloir vous inscrire en ligne pour obtenir une licence de Badminton avec le club de Gradignan.</strong>
    </p>

    <ul>
        <li>
            <p>
                Si vous étiez licencié(e) la saison précédente, connectez-vous à votre espace <a href="https://www.myffbad.fr/connexion">MyFFBAD</a> avec votre numéro de licence. Puis faite votre demande renouvellement de licence en ligne.
            </p>
        </li>
        <li>
            <p>
                Si vous êtes nouveau ou nouvelle licencié(e), connectez-vous sur <a href="https://www.myffbad.fr/club/569">MyFFBAD</a> et faite votre demande de licence. 
            </p>
        </li>
    </ul>
    <P> 
        Il faut choisir Adulte Jeud Libre ou Adulte 1 entrainement <strong>(NE PAS CHOISIR Licence Lectra)</strong> et payer en ligne. Lorsque votre licence sera active vous pourrez obtenir son remboursement en faisant la demande par mail à Christophe Mahéo.
    </p>

    <br><br>
        Merci de prendre connaissance des règles de fonctionnement:
        <br><br>
        <strong>Pour ouvrir la salle il faut un volontaire chaque jour pour prendre le set de Badminton</strong>
        <ul>
            <li>Sur la page d’accueil du site de la section, on peut se déclarer pour le jour même ou le lendemain (ou bien sûr annuler en cas d’impondérable)</li>
            <li>Si personne n’est volontaire, un mail de rappel est envoyé chaque jour à 11h15. 
                <br>Sans candidat, la séance est annulée. Note : <strong>Il est interdit de prendre le set sans au préalable se porter candidat sur le site</strong></li>
        </ul>
        <br>
        Le volontaire qui prend le set s’engage à:
        <ul>
            <li>Prendre le set de badminton, être au plus tard à 12h à la salle, ramener le set complet au plus tard à 14h</li>
            <li>Fermer le casier des poteaux en fin de séance</li>
            <li>S'assurer que tout le monde quitte les vestiaires à 13h10 au plus tard</li>
            <li>Vérifier que les volants sont tous rangés dans le bon sens dans les tubes. 
                <br>Les volants mal rangés se déforment et terminent à la poubelle. Pour info le coût à l’année est d’environ 500€</li>
        </ul>
        <br>

        <strong>Chaque membre de la section s’engage à respecter les règles suivantes</strong>
        <ul>
            <li>Faciliter la tache du volontaire qui se charge du set</li>
            <ul><li>Rangement des volants, sortie des vestiaires à l’heure, etc…</li></ul>
        </ul>
        <ul>
            <li>Aider ou montage et démontage des filets et poteaux</li>
            <ul><li>Les filets et poteaux doivent être systématiquement démontés après chaque séance, même s’ils étaient déjà installés à votre arrivée</li></ul>
        </ul>
        <ul>
            <li><strong>Quitter les vestiaires impérativement au plus tard à 13h10</strong>, afin de ne pas y croiser les enfants</li>
            <ul><li>Le gardien veille régulièrement au respect de cette règle. Il peut nous interdire l’accès en cas de débordement.</li></ul>
        </ul>
@stop