<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>PDF - Файлы
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
    include __DIR__ . '/docs/header.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorMessage)) {
            $errorCaption = Locale::getValue('error.fileedit'); //'Ошибка редактирования';
            require __DIR__ . '/docs/card-error.php';
        }
        ?>
    </div>
</body>