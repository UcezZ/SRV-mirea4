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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>PDF - <?= Locale::getValue('password.title') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/card-state.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
</head>

<body>
    <?php
    include __DIR__ . '/private/docs/header.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorCaption) && isset($errorMessage)) {
            require __DIR__ . '/private/docs/card-error.php';
        }

        if (isset($successCaption) && isset($successMessage)) {
            require __DIR__ . '/private/docs/card-success.php';
            print('</div></body></html>');
            exit;
        }
        ?>

        <div class="card-wrapper">
            <div class="card">
                <div class="card-header"><?= Locale::getValue('password.title') ?></div>
                <form action="" method="POST" enctype="utf8">
                    <table class="card-contents">
                        <tr>
                            <td><?= Locale::getValue('auth.login') ?></td>
                            <td><?= $user->getLogin() ?></td>
                        </tr>
                        </tr>
                        <tr>
                            <td><?= Locale::getValue('auth.oldpassword') ?></td>
                            <td><input type="password" name="oldpassword" /></td>
                        </tr>
                        <tr>
                            <td><?= Locale::getValue('auth.newpassword') ?></td>
                            <td><input type="password" name="password" /></td>
                        </tr>
                        <tr>
                            <td><?= Locale::getValue('auth.confirmnewpassword') ?></td>
                            <td><input type="password" name="passwordConfirm" /></td>
                        </tr>
                    </table>
                    <div class="submit-wrapper">
                        <button type="submit"><?= Locale::getValue('profile.changepassword') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>