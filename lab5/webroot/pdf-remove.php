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

if (isset($_POST['f'])) {
    $pdf = PDF::getByAlias($_POST['f']);
    if ($pdf) {
        switch ($pdf->delete()) {
            case 0:
                header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './files.php');
                exit;
            case 1:
                $errorMessage = Locale::getValue('error.sql.message')/*'Ошибка обработки запроса<br>'*/ . htmlspecialchars(print_r(SQL::getErrors(), true));
                break;
            case 2:
                $errorMessage = Locale::getValue('error.filedelete.message'); //'У вас нет права удалять этот файл!';
                break;
        }
    } else {
        $errorMessage = Locale::getValue('error.file.message'); //'Запрошенный файл не найден или у вас нет к нему доступа!';
    }
}

?>
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
    include __DIR__ . '/private/docs/header.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorMessage)) {
            $errorCaption = Locale::getValue('error.filedelete'); //'Ошибка удаления';
            require __DIR__ . '/private/docs/card-error.php';
        }
        ?>
    </div>
</body>