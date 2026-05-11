<?php $pager->setSurroundCount(2) ?>
<div class="d-flex justify-content-center">
    <nav>
        <ul class="pagination">
            <li class="page-item <?= $pager->hasPreviousPage() ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $pager->getPreviousPage() ?>">
                    &laquo; Précédent
                </a>
            </li>
            &nbsp;&nbsp;

            <?php foreach ($pager->links() as $link): ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </li>
                &nbsp;&nbsp;
            <?php endforeach ?>

            <li class="page-item <?= $pager->hasNextPage() ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $pager->getNextPage() ?>">
                    Suivant &raquo;
                </a>
            </li>
        </ul>
    </nav>
</div>