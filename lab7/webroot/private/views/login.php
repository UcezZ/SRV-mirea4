<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>PDF - <?= Locale::getValue('menu.login') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/card-state.css">
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
        ?>

        <div class="card-wrapper">
            <div class="card">
                <div class="card-header"><?= Locale::getValue('login.cardtitle') ?></div>
                <form action="" method="POST" enctype="utf8">
                    <table class="card-contents">
                        <td><?= Locale::getValue('auth.login') ?></td>
                        <td><input name="login" /></td>
                        </tr>
                        <tr>
                            <td><?= Locale::getValue('auth.password') ?></td>
                            <td><input type="password" name="password" /></td>
                        </tr>
                    </table>
                    <div class="submit-wrapper">
                        <button type="submit"><?= Locale::getValue('login.submit') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>