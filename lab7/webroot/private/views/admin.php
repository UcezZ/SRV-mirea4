<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title>PDF - <?= Locale::getValue('menu.admin') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/card-state.css">
    <link rel="stylesheet" type="text/css" href="./css/form-delete.css">
    <link rel="stylesheet" type="text/css" href="./css/toggle.css">
    <link rel="stylesheet" type="text/css" href="./css/form-editor.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
</head>

<body>
    <?php
    include __DIR__ . '/docs/header.php';
    ?>
    <div class="main">
        <div class="card-wrapper">
            <div class="card">
                <div class="card-header"><?= Locale::getValue('admin.activesessions') ?></div>
                <table class="card-contents">
                    <thead>
                        <th><?= Locale::getValue('common.id') ?></th>
                        <th><?= Locale::getValue('auth.login') ?></th>
                        <th><?= Locale::getValue('session.expires') ?></th>
                        <th><?= Locale::getValue('session.action') ?></th>
                    </thead>
                    <tbody>
                        <?php
                        if ($result = SQL::sqlResultToArray(SQL::runQuery("SELECT token.ID, user.login, DATE_ADD(token.expires, INTERVAL 3 HOUR) AS expires FROM token JOIN user ON token.ID_user = user.ID WHERE expires > NOW()"))) {
                            foreach ($result as $row) {
                                require __DIR__ . '/docs/row-session.php';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-wrapper flex-wrap">
            <div class="card">
                <div class="card-header"><?= Locale::getValue('admin.users') ?></div>
                <div class="card-contents">
                    <div class="card-wrapper">
                        <?php
                        if (($result = SQL::sqlResultToArray(SQL::runQuery("SELECT * FROM user WHERE ID > 1"))) && sizeof($result)) {
                            foreach ($result as $row) {
                                $userprofile = new User($row);
                                require __DIR__ . '/docs/card-userprofile.php';
                            }
                        } else {
                            $errorCaption = Locale::getValue('error.nousers'); //'Нет пользователей';
                            $errorMessage = Locale::getValue('error.nousers.message'); //'В системе нет ни одного рарегистрированного пользователя';
                            require __DIR__ . '/docs/card-error.php';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-wrapper flex-wrap">
            <div class="card">
                <div class="card-header"><?= Locale::getValue('menu.files') ?></div>
                <div class="card-contents">
                    <div class="card-wrapper">
                        <?php
                        if (($result = SQL::sqlResultToArray(SQL::runQuery("SELECT * FROM pdf"))) && sizeof($result)) {
                            foreach ($result as $row) {
                                $pdf = new PDF($row);
                                $userprofile = User::getUserById($pdf->getUserID());
                                require __DIR__ . '/docs/card-pdf.php';
                            }
                        } else {
                            $errorCaption = Locale::getValue('error.nofiles'); //'Нет документов';
                            $errorMessage = Locale::getValue('error.nofiles.message2'); //'В системе нет ни одного загруженного документа';
                            require __DIR__ . '/docs/card-error.php';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>