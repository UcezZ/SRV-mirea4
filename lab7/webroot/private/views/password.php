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
    include __DIR__ . '/docs/header.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorCaption) && isset($errorMessage)) {
            require __DIR__ . '/docs/card-error.php';
        }

        if (isset($successCaption) && isset($successMessage)) {
            require __DIR__ . '/docs/card-success.php';
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