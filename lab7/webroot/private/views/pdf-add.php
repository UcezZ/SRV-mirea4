<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>PDF - <?= Locale::getValue('file.upload.title') ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/card-state.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/toggle.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
</head>

<body>
    <?php
    require __DIR__ . '/docs/header.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorMessage)) {
            $errorCaption = Locale::getValue('error.upload'); //'Ошибка загрузки';
            require __DIR__ . '/docs/card-error.php';
            require __DIR__ . '/docs/form-upload.php';
        } else if (isset($pdf)) {
            $successCaption = Locale::getValue('success.upload'); //'Файл успешно загружен';
            require __DIR__ . '/docs/card-success-upload.php';
        } else {
            require __DIR__ . '/docs/form-upload.php';
        }
        ?>
    </div>
</body>