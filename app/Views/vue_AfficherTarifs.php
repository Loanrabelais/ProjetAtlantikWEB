<h2><?php echo $TitreDeLaPage ?></h2>

<?php
$tariffLookup = [];
foreach ($tarifs as $tarif) {
    // Trouver la période correspondante pour ce tarif
    foreach ($periodes as $periode) {
        if ($periode->DATEDEBUT == $tarif->DATEDEBUT) {
            $tariffLookup[$tarif->typeLETTRECATEGORIE][$tarif->NOTYPE][$periode->NOPERIODE] = $tarif->TARIF;
            break;
        }
    }
}
?>
<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th scope="col" rowspan="2">Categorie</th>
            <th scope="col" rowspan="2">Type</th>
            <th scope="col" colspan="<?php echo count($periodes); ?>">Periodes</th>
        </tr>
        <tr>
            <?php foreach ($periodes as $periode) {
                echo '<th>'.$periode->DATEDEBUT.' <br> '.$periode->DATEFIN.'</th>';
            }?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $categorie): 
            // compter les types de la catégorie
            $count = 0;
            foreach ($types as $type) {
                if ($type->LETTRECATEGORIE == $categorie->LETTRECATEGORIE) $count++;
            }
        ?>
        <tr>
        <?php
        $first = true;
        foreach ($types as $type):
            if ($type->LETTRECATEGORIE != $categorie->LETTRECATEGORIE) continue;
            if (!$first) echo '</tr><tr>';
            ?>
            <?php if ($first): ?>
                <th scope="row" rowspan="<?php echo $count; ?>"><?php echo $categorie->LETTRECATEGORIE.'<br>'.$categorie->LIBELLE; ?></th>
            <?php endif; ?>
            <td><?= $type->LETTRECATEGORIE . $type->NOTYPE ?> - <?= $type->LIBELLE ?></td>
            <?php foreach ($periodes as $periode): 
                $tarif = $tariffLookup[$categorie->LETTRECATEGORIE][$type->NOTYPE][$periode->NOPERIODE] ?? '—';
                ?>
                <td><?= $tarif ?>€</td>
            <?php endforeach; ?>
        <?php
            $first = false;
        endforeach;
        ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
