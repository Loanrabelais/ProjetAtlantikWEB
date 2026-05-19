<h2> <?= htmlspecialchars($TitreDeLaPage) ?></h2>

<div class="d-flex">
    <!-- Sidebar -->
    <nav class="bg-light p-3" style="width:200px; min-height:100vh;">
      <h6 class="mb-3">Navigation</h6>
      <ul class="nav flex-column">
        <?php foreach ($secteurs as $secteur) : ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo site_url('afficherhorairestraversee/' . $secteur->NOSECTEUR) ?>"><?= htmlspecialchars($secteur->NOM, ENT_QUOTES) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <main class="flex-grow-1 p-4">
    <?php if (isset($secteurSelectionne)) :
        if (!empty($liaisons)) : ?>
            <p>Sélectionner la liaison, et la date souhaitée</p>
            <form method="post" action="<?= site_url('afficherhorairestraversee') ?>">
                <div class="d-flex gap-3 align-items-center">
                    <select name="liaison_id" class="form-select" required>
                    <option value="">Choisir une liaison</option>
                    <?php foreach ($liaisons as $liaison): ?>
                        <option value="<?= (int)$liaison->NOLIAISON ?>"><?= htmlspecialchars($liaison->PORT_DEPART->NOM).' - '.htmlspecialchars($liaison->PORT_ARRIVEE->NOM) ?></option>
                    <?php endforeach; ?>
                    </select>

                    <option value="">Choisir une date</option>
                    <input type="date" id="date" name="date" required>

                    <button class="btn btn-primary" type="submit">Afficher</button>
                </div>
            </form>
        <?php else : ?>
            <p>Aucune liaison pour le secteur sélectionné.</p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($traversees)) :
        if (!empty($traversees)) : ?>
            Traversées et places disponibles par catégorie :
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Heure</th>
                        <th>Bateau</th>
                        <?php foreach ($categories as $categorie) : ?>
                            <th><?= htmlspecialchars($categorie->LETTRECATEGORIE, ENT_QUOTES) ?> - <?= htmlspecialchars($categorie->LIBELLE, ENT_QUOTES) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($traversees as $traversee) : ?>
                        <tr>
                            <td><?= anchor('reservertraversee/' . (int)$traversee->NOTRAVERSEE, (int)$traversee->NOTRAVERSEE) ?></td>
                            <td><?= htmlspecialchars((new DateTime($traversee->DATEHEUREDEPART))->format('H:i'), ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($traversee->NOMBATEAU, ENT_QUOTES) ?></td>
                            <?php foreach ($traversee->cats as $categorie) : ?>
                                <td><?= (int)$categorie->PLACESDISPONIBLES ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune traversée disponible pour la liaison et la date sélectionnées.</p>
        <?php endif; ?>
    <?php endif; ?>
    </main>
</div>