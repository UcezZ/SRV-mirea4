<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="./css/style.css" rel="stylesheet">
    <link href="./css/form.css" rel="stylesheet">
</head>

<body>
    <?php
    if (isset($_SESSION['error'])) {
        require(__DIR__ . '/error.php');
        unset($_SESSION['error']);
    }
    ?>
    <div class="center-wrapper">
        <form action="<?= $action ?>" method="post">
            <h4 class="center-wrapper"><?= $title ?></h4>
            <label>Логин</label>
            <input type="text" name="login" placeholder="Введите логин" required>
            <label>Пароль</label>
            <input type="password" name="password" placeholder="Введите пароль" required>
            <button type="submit" title="Вход в систему"><?= $submit ?></button>
        </form>
    </div>
</body>

</html>