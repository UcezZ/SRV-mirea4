<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/core/locale.php';
include_once __DIR__ . '/private/core/theme.php';

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

require __DIR__ . '/private/views/user-edit.php';
