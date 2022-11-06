<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/filestream.php';
include_once __DIR__ . '/private/pdf.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

if (TokenHandler::check()) {
    $user = User::getUser();
} else {
    header('Location: ./');
    exit;
}

if (isset($_FILES['file'])) {
    if ($_FILES['file']['tmp_name']) {
        if (strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)) == 'pdf') {
            $pdf = PDF::prepare($_POST['name']);
            if (!file_exists(__DIR__ . '/private/files/')) {
                mkdir(__DIR__ . '/private/files/', 0777, true);
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], $pdf->getPath())) {
                $pdf->register();
            } else {
                $errorMessage = Locale::getValue('error.upload.message0');
            }
        } else {
            $errorMessage = Locale::getValue('error.upload.message1');
        }
    } else {
        $errorMessage = Locale::getValue('error.upload.message2');
    }
}

?>
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
    include __DIR__ . '/private/docs/header.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorMessage)) {
            $errorCaption = Locale::getValue('error.upload'); //'Ошибка загрузки';
            require __DIR__ . '/private/docs/card-error.php';
        } else if (isset($pdf)) {
            $successCaption = Locale::getValue('success.upload'); //'Файл успешно загружен';
            require __DIR__ . '/private/docs/card-success-upload.php';
        } else {
            include __DIR__ . '/private/docs/form-upload.php';
        }
        ?>
    </div>
</body>