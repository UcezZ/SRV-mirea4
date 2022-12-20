<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>PDF - <?= Locale::getValue('menu.files') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/card-state.css">
    <link rel="stylesheet" type="text/css" href="./css/biggreenbutton.css">
    <link rel="stylesheet" type="text/css" href="./css/toggle.css">
    <link rel="stylesheet" type="text/css" href="./css/form-delete.css">
    <link rel="stylesheet" type="text/css" href="./css/form-editor.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
</head>

<body>
    <?php
    require __DIR__ . '/docs/header.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorMessage)) {
            header('HTTP/1.1 404 Not Found');
            $errorCaption =  Locale::getValue('error.notfound');
            require __DIR__ . '/docs/card-error.php';
            exit;
        }
        if (isset($pdfCollection) && !sizeof($pdfCollection)) {
            $errorCaption =  Locale::getValue('error.nofiles');
            $errorMessage =  Locale::getValue('error.nofiles.message');
            require __DIR__ . '/docs/card-error.php';
        }
        ?>
        <div class="centerer-wrapper row">
            <div class="centerer-wrapper">
                <a class="big-green-button add-pdf-icon" href="./pdf-add.php"><span><?= Locale::getValue('file.add') ?></span></a>
            </div>
        </div>
        <div class="card-wrapper flex-wrap">
            <?php
            if (sizeof($pdfCollection)) {
                foreach ($pdfCollection as $pdf) {
                    require __DIR__ . '/docs/card-pdf.php';
                }
            } ?>
        </div>
    </div>
</body>