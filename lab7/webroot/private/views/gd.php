<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>PDF - <?= Locale::getValue('menu.gd') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/card-state.css">
    <link rel="stylesheet" type="text/css" href="./css/form-delete.css">
    <link rel="stylesheet" type="text/css" href="./css/toggle.css">
    <link rel="stylesheet" type="text/css" href="./css/form-editor.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
</head>

<body>
    <?php
    include __DIR__ . '/docs/header.php';
    ?>
    <div class="main card-wrapper flex-wrap">
        <div class="card">
            <div class="card-header"><?= Locale::getValue('gd.linear') ?></div>
            <div class="card-contents"><img src="./gd.php?m=lin&w=960&h=640&p=10&x=8"></div>
        </div>
        <div class="card">
            <div class="card-header"><?= Locale::getValue('gd.circular') ?></div>
            <div class="card-contents"><img src="./gd.php?m=circ&w=640&h=640"></div>
        </div>
        <div class="card">
            <div class="card-header"><?= Locale::getValue('gd.columnar') ?></div>
            <div class="card-contents"><img src="./gd.php?m=col&w=1740&h=600&p=10"></div>
        </div>
    </div>
</body>