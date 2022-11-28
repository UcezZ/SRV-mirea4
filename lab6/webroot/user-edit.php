<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

if (TokenHandler::check()) {
    $user = User::getUser();
} else {
    header('Location: ./');
    exit;
}

if (isset($_POST['u']) && isset($_POST['locale']) && isset($_POST['theme'])) {
    if (($userById = User::getUserById($_POST['u'])) && ($user->getId() == $_POST['u'] || $user->getId() == 1)) {
        if ($userById->edit($_POST['locale'], $_POST['theme'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './files.php');
            exit;
        } else {
            $errorMessage = Locale::getValue('error.sql.message')/*'Ошибка обработки запроса<br>'*/ . htmlspecialchars(print_r(SQL::getErrors(), true));
        }
    } else {
        $errorMessage = Locale::getValue('error.profileedit.message1'); //'Запрошенный файл не найден или у вас нет к нему доступа!';
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
            $errorCaption = Locale::getValue('error.fileedit'); //'Ошибка редактирования';
            require __DIR__ . '/private/docs/card-error.php';
        }
        ?>
    </div>
</body>