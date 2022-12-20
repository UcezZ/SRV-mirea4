<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/core/locale.php';
include_once __DIR__ . '/private/core/theme.php';

if (TokenHandler::check()) {
    header('Location: ./');
    exit;
}

if (sizeof($_POST)) {

    function checkPost()
    {
        if (!isset($_POST['login']) || !strlen($_POST['login'])) {
            return Locale::getValue('error.register.message0'); //'Логин не указан!';
        } else {
            preg_match('/[a-zA-Z0-9_]{5,32}/', $_POST['login'], $matches);
            if (sizeof($matches) != 1 || $matches[0] != $_POST['login']) {
                return Locale::getValue('error.register.message1'); //'Логин должен состоять только из латиницы и цифр и знака "_"!';
            }
        }
        if (!isset($_POST['password']) || !strlen($_POST['password'])) {
            return Locale::getValue('error.register.message2'); //'Пароль не указан!';
        }
        if (!isset($_POST['passwordConfirm']) || !strlen($_POST['passwordConfirm'])) {
            return Locale::getValue('error.register.message3'); //'Повторите ввод пароля!';
        }
        if (strcmp($_POST['password'], $_POST['passwordConfirm'])) {
            return Locale::getValue('error.register.message4'); //'Введённые пароли не совпадают!';
        }
        if (strtolower($_POST['login']) == strtolower($_POST['password'])) {
            return Locale::getValue('error.register.message5'); //'Логин и пароль не должны совпадать!';
        }
        return null;
    }

    if (!$errorMessage = checkPost()) {
        if (User::register($_POST['login'], $_POST['password'])) {
            $successCaption = Locale::getValue('success.register'); //'Успешная регистрация';
            $successMessage = Locale::getValue('success.register.message'); //'Вы успешно зарегистрировались!<br>Используйте указанные при регистрации логин и пароль чтобы войти.';
        } else {
            $errorMessage = Locale::getValue('error.register.message6'); //'Пользователь с таким логином уже существует!';
        }
    }
    if ($errorMessage) {
        $errorCaption = Locale::getValue('error.register'); //'Ошибка регистрации';
    }
}

require __DIR__ . '/private/views/register.php';
