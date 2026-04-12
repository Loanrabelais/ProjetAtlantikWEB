<h2><?php echo $TitreDeLaPage ?></h2>
<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th scope="col" rowspan="2">Categorie</th>
            <th scope="col" rowspan="2">Type</th>
            <th scope="col" colspan="<?php echo count($periodes); ?>">Periodes</th>
        </tr>
            <?php foreach ($periodes as $periode) {
                echo '<th scope="row">'.$periode->DATEDEBUT.' <br> '.$periode->DATEFIN.'</td>';
            }?>
        </tr>
        <?php foreach ($categories as $categorie): 
            // compter les types de la catégorie
            $count = 0;
            foreach ($types as $type) {
                if ($type->LETTRECATEGORIE == $categorie->LETTRECATEGORIE) $count++;
            }
        ?>
        <tr>
            <th scope="row" rowspan="<?= $count ?>"><?= $categorie->LETTRECATEGORIE ?><br><?= $categorie->LIBELLE ?></th>
            <?php
            $first = true;
            foreach ($types as $type):
                if ($type->LETTRECATEGORIE != $categorie->LETTRECATEGORIE) continue;
                if (!$first) echo '</tr><tr>';
                ?>

                <td><?= $type->LETTRECATEGORIE . $type->NOTYPE ?> - <?= $type->LIBELLE ?></td>
            <?php
                $first = false;
            endforeach;
            ?>
        </tr>
        <?php endforeach; ?>
    </thead>
    <tbody>
        <?php foreach ($tarifs as $tarif): ?>
            <td><?= $tarif->TARIF ?>€</td>
        <?php endforeach; ?>
    </tbody>
</table>
