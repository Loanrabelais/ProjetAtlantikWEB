<?php $session = session(); //initialisation de la session ?>
<h2> <?php htmlspecialchars($TitreDeLaPage) ?></h2>

<h6> Liaison <?php echo $nomLiaison->PORT_DEPART; $nomLiaison->PORT_ARRIVEE; ?></h6>
<h6> Traversee N° <?php echo $traversee->NOTRAVERSEE; ?> </t>
le <?php echo $traversee->DATEHEUREDEPART; ?></h6><br>
Saisir les informations relatives à la réservation

<br>
<h6> Nom: <?php echo $session->get('nom'); ?> </h6>
<h6> adresse: <?php echo $session->get('adresse'); ?> </h6>
<h6> cp: <?php echo $session->get('codepostal'); ?> Ville: <?php echo $session->get('ville'); ?> </h6>

<table class="table table-bordered">
    <thead>
        <tr>
                <td></td>
                <td> Tarifs en € </td>
                <td> Quantité </td>
            </tr>
    </thead>
    <tbody>
        <?php foreach ($tarifs as $tarif): ?>
            <tr>
                <td><?= htmlspecialchars($tarif->LIBELLE) ?></td>
                <td><?= htmlspecialchars($tarif->TARIF) ?></td>
                <td><?= htmlspecialchars('A implémenter') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>