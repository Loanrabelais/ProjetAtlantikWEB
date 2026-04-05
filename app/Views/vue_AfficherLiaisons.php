<h2><?php echo $TitreDeLaPage ?></h2>
<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th scope="col" rowspan="2">Secteur</th>
            <th scope="col" colspan="4">Liaison</th>
        </tr>
        <tr>
            <th scope="col">Code Liaison</th>
            <th scope="col">Distance en milles marin</th>
            <th scope="col">Port de départ</th>
            <th scope="col">Port d'arrivée</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            $liaisonPrecedente = null;
            foreach ($liaisons as $liaison) :
            ?>
            <tr>
                <?php
                if ($liaison->Nomsecteur == $liaisonPrecedente) {
                    echo '<td></td>';
                } else {
                    echo '<td>' . $liaison->Nomsecteur . '</td>';
                    $liaisonPrecedente = $liaison->Nomsecteur;
                }  
                ?>
                <td><?php echo anchor('affichertarifs/' . $liaison->NOLIAISON, $liaison->NOLIAISON) ?></td>
                <td><?php echo $liaison->DISTANCE ?></td>
                <td><?php echo $liaison->PORT_DEPART ?></td>
                <td><?php echo $liaison->PORT_ARRIVEE ?></td>
            </tr>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>