<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/core/locale.php';
include_once __DIR__ . '/private/core/theme.php';

if (TokenHandler::check()) {
    header('Location: ./');
    exit;
}
if (isset($_POST['login']) && isset($_POST['password'])) {
    if (User::login($_POST['login'], $_POST['password'])) {
        header('Location: ./');
    } else {
        $errorCaption = Locale::getValue('error.login'); //'Ошибка входа';
        $errorMessage = Locale::getValue('error.login.message'); //'Логин или пароль не распознаны';
    }
}

require __DIR__ . '/private/views/login.php';
