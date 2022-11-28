<div class="card-wrapper success">
    <div class="card">
        <div class="card-header"><?= $successCaption ?></div>
        <div class="card-contents">
            <span><?= '[' . $pdf->getHumanSize() . ']<br>' . htmlspecialchars($pdf->getName()) ?></span>
        </div>
        <div class="card-footer">
            <a href="./files.php"><?= Locale::getValue('profile.myfiles') ?></a>
            <a href="./files.php?f=<?= $pdf->getAlias() ?>" target="_blank"><?= Locale::getValue('file.view') ?></a>
        </div>
    </div>
</div>