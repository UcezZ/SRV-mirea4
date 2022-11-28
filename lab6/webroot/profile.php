<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/pdf.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

if (TokenHandler::check()) {
    $user = User::getUser();
} else {
    header('Location: ./');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>PDF - <?= Locale::getValue('menu.profile') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/form-editor.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
</head>

<body>
    <?php
    include __DIR__ . '/private/docs/header.php';
    ?>
    <div class="main">
        <div class="card-wrapper">
            <?php
            $userprofile = $user;
            require __DIR__ . '/private/docs/card-userprofile.php';
            ?>
        </div>
    </div>
</body>