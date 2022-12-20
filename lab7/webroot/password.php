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

if (sizeof($_POST)) {
    function checkPost()
    {
        if (!isset($_POST['oldpassword']) || !strlen($_POST['oldpassword'])) {
            return Locale::getValue('error.password.message0'); //'Старый пароль не указан!';
        }
        if (!isset($_POST['password']) || !strlen($_POST['password'])) {
            return Locale::getValue('error.password.message1'); //'Новый пароль не указан!';
        }
        if (!isset($_POST['passwordConfirm']) || !strlen($_POST['passwordConfirm'])) {
            return Locale::getValue('error.password.message2'); //'Повторите ввод нового пароля!';
        }
        if (strcmp($_POST['password'], $_POST['passwordConfirm'])) {
            return Locale::getValue('error.password.message3'); //'Введённые пароли не совпадают!';
        }
        if (strtolower($_POST['oldpassword']) == strtolower($_POST['password'])) {
            return Locale::getValue('error.password.message4'); //'Старый и новый пароли не должны совпадать!';
        }
        return null;
    }

    if (!$errorMessage = checkPost()) {
        switch ($user->changePassword($_POST['oldpassword'], $_POST['password'])) {
            case 0:
                $successCaption = Locale::getValue('success.password'); //'Пароль успешно изменён';
                $successMessage = Locale::getValue('success.password.message'); //'Вы успешно изменили пароль.<br>Теперь при входе используйте новый пароль.';
                break;
            case 1:
                $errorMessage = Locale::getValue('error.password.message5'); //'Старый пароль указан неверно!';
                break;
            case 2:
                $errorMessage = Locale::getValue('error.common.message')/*'Другая ошибка.<br>'*/ . print_r(SQL::getErrors(), true);
                break;
        }
    }
    if ($errorMessage) {
        $errorCaption = Locale::getValue('error.password'); //'Ошибка смены пароля';
    }
}

require __DIR__ . '/private/views/password.php';
