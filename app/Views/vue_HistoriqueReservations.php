<h2> <?= htmlspecialchars($TitreDeLaPage) ?></h2>

<?php if (empty($reservations)) : ?>
    <p>Aucune réservation trouvée.</p>
<?php else : ?>
    <div class="d-flex">
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>N° de réservation</th>
                    <th>Date reservation</th>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Date départ</th>
                    <th>Montant total</th>
                    <th>Payé</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation) : ?>
                    <tr>
                        <td><?= (int)$reservation->NORESERVATION ?></td>
                        <td><?= htmlspecialchars($reservation->DATEHEURE) ?></td>
                        <td><?= htmlspecialchars($reservation->liaison->PORT_DEPART) ?></td>
                        <td><?= htmlspecialchars($reservation->liaison->PORT_ARRIVEE) ?></td>
                        <td><?= htmlspecialchars($reservation->traversee->DATEHEUREDEPART) ?></td>
                        <td><?= htmlspecialchars($reservation->MONTANTTOTAL) ?> €</td>
                        <td><?= $reservation->PAYE ? 'Oui' : 'Non' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>