<?php $session = session(); //initialisation de la session ?>
<h2> <?php htmlspecialchars($TitreDeLaPage) ?></h2>
<?php
if ($TitreDeLaPage == 'Saisie incorrecte'){
    echo service('validation')->listErrors();
    echo anchor('afficherhorairestraversee', 'Retour aux horaires de traversée', ['class' => 'btn btn-primary']);
}
elseif($TitreDeLaPage == 'Capacité dépassée'){
    echo '<h3> la capacité d une des catégorie a été dépassée <h3>';
    echo anchor('afficherhorairestraversee', 'Retour aux horaires de traversée', ['class' => 'btn btn-primary']);
}
elseif($TitreDeLaPage == 'Reservation ajoutée'){ ?>
    <h6> Liaison <?php echo $nomLiaison->PORT_DEPART; $nomLiaison->PORT_ARRIVEE; ?></h6>
    <h6> Traversee N° <?php echo $traversee->NOTRAVERSEE; ?> </t>
    le <?php echo $traversee->DATEHEUREDEPART; ?></h6><br>
    <h6> Réservation enregistrée sous le n° <?php echo $noReservationAjoute ?> </h6><br>
    <?php echo $session->get('nom'), '</t>', 
    $session->get('adresse'),'</t>',
    $session->get('codepostal'),'</t>',
    $session->get('ville'),'</t>', '<br>';
    foreach ($enregistrements as $enregistrement){
        if ($enregistrement['Quantite'] != 0){
            echo $enregistrement['Reference'], ' :', $enregistrement['Quantite'], '<br>';
        }
    }
    ?>
    Montant total à régler : <?php echo $montantTotal; ?> euros </h6><br>
    Modalités de règlement : Carte Bancaire ??? <!-- Aucune modalité de règlement spécifiée dans le formulaire donc aucune valeurs a mettre ici -->
<?php } ?>
