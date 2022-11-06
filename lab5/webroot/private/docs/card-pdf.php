<div class="card">
    <div class="card-header"><?= isset($userprofile) ? $userprofile->getLogin() : $user->getLogin() . ' #' . $pdf->getId() ?>
        <form class="remove-pdf toggle-wrapper" method="POST" action="./pdf-remove.php">
            <input type="hidden" name="f" value="<?= $pdf->getAlias() ?>" />
            <span class="centerer-wrapper"><?= Locale::getValue('file.confirmdelete') ?></span>
            <div class="centerer-wrapper">
                <input id="checkbox<?= $pdf->getId() ?>" type="checkbox" required />
                <label for="checkbox<?= $pdf->getId() ?>">
                    <span></span>
                </label>
            </div>
            <button type="submit">
                <img src="./media/icons/delete.svg">
            </button>
        </form>
    </div>
    <?php
    require __DIR__ . '/form-editor-file.php';
    ?>
    <table class="card-contents">
        <tr>
            <td><?= Locale::getValue('common.id') ?></td>
            <td><?= $pdf->getId() ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('common.name') ?></td>
            <td><?= $pdf->getName() ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('file.size') ?></td>
            <td><?= $pdf->getHumanSize() ?></td>
        </tr>
    </table>
    <div class="card-footer">
        <a type="button" value="Просмотр" href="./files.php?f=<?= $pdf->getAlias() ?>" target="_blank"><?= Locale::getValue('file.view') ?></a>
        <a type="button" value="Просмотр" href="./files.php?f=<?= $pdf->getAlias() ?>&q=download"><?= Locale::getValue('file.download') ?></a>
    </div>
</div>