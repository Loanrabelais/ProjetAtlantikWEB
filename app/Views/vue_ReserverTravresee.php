<?php $session = session(); //initialisation de la session ?>
<h2> <?php htmlspecialchars($TitreDeLaPage) ?></h2>

<?php
if ($TitreDeLaPage == 'Saisie incorrecte')
    echo service('validation')->listErrors();
echo form_open('reservertraversee/'.$traversee->NOTRAVERSEE);
?>
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
        <?php $i = 0;
        foreach ($tarifs as $tarif):
            $i++; ?>
            <tr>
                <td><?= htmlspecialchars($tarif->LIBELLE) ?></td>
                <td><?= htmlspecialchars($tarif->TARIF) ?></td>
                <td>
                    <input type="hidden" name="enregisterments[<?= $i ?>][Reference]" value="<?= htmlspecialchars($tarif->LIBELLE) ?>" />
                    <input type="hidden" name="enregisterments[<?= $i ?>][Prix]" value="<?= htmlspecialchars($tarif->TARIF) ?>" />
                    <input type="text" name="enregisterments[<?= $i ?>][Quantite]" value="0" />
                </td>
            </tr>
        <?php endforeach; ?>
        <br>
        <input type="submit" name="submit" value="Valider" />
        <?php echo form_close(); ?>
    </tbody>
</table>