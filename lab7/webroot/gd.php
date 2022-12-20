<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/pdf.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';
include_once __DIR__ . '/private/gdwrapper.php';

if (TokenHandler::check()) {
    $user = User::getUser();
}
if (!isset($user) || $user->getId() != 1) {
    header('Location: ./');
    exit;
}

if (isset($_POST['tokenid'])) {
    SQL::runQuery(
        "UPDATE token SET expires = NOW() WHERE ID = ?",
        'i',
        $_POST['tokenid']
    );
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './admin.php');
    exit;
}


if (isset($_GET['m']) || isset($_GET['p']) || isset($_GET['w']) || isset($_GET['h']) || isset($_GET['x']) || isset($_GET['y'])) {
    $mode = 0; //0 linear; 1 circular; 2 columnar
    $parts = 5;
    $width = 300;
    $height = 300;
    $xpad = 5;
    $ypad = 5;


    if (isset($_GET['m'])) {
        switch ($_GET['m']) {
            case 'lin':
                $mode = 0;
                break;
            case 'circ':
                $mode = 1;
                break;
            case 'col':
                $mode = 2;
        }
    }

    if (isset($_GET['p']) && intval($_GET['p']) && $_GET['p'] > 5) {
        $parts = (int)$_GET['p'];
        if ($parts > 255) {
            $parts = 255;
        }
    }
    if (isset($_GET['w']) && intval($_GET['w']) && $_GET['w'] > 100) {
        $width = (int)$_GET['w'];
        if ($width > 2000) {
            $width = 2000;
        }
    }
    if (isset($_GET['h']) && intval($_GET['h']) && $_GET['h'] > 100) {
        $height = (int)$_GET['h'];
        if ($height > 2000) {
            $height = 2000;
        }
    }
    if (isset($_GET['x']) && $_GET['x'] >= 0 && $_GET['x'] < $width / 3) {
        $xpad = (int)$_GET['x'];
    }
    if (isset($_GET['y']) && $_GET['y'] >= 0 && $_GET['y'] < $height / 3) {
        $ypad = (int)$_GET['y'];
    }


    switch ($mode) {
        case 0:
            GDWrapper::drawLinear($parts, $width, $height, $xpad, $ypad);
            break;
        case 1:
            GDWrapper::drawCircular($parts, $width, $height, $xpad, $ypad);
            break;
        case 2:
            GDWrapper::drawColumnar($parts, $width, $height, $xpad, $ypad);
            break;
    }
}
?>
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
    include __DIR__ . '/private/docs/header.php';
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