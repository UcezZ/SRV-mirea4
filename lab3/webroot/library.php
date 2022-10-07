<?php
require "lib/lib.php";
safe_session_start();
if (!isset($_SESSION['login'])) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Администратор</title>
    <link href="./css/book.css" rel="stylesheet">
    <link href="./css/navi.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>

<body>
    <form class="navi flex space-between" action="./lib/signout.php">
        <h4>Пользователь: <?= $_SESSION['login']; ?></h4>
        <input type="submit" value="Выйти">
    </form>
    <?php
    if (isset($_SESSION['error'])) {
        require(__DIR__ . '/error.php');
        unset($_SESSION['error']);
    }
    ?>
    <div>
        <?php
        $books = get_books();

        foreach ($books as $book) {
            require(__DIR__ . '/docs/book.php');
        }

        if (isset($_SESSION) && $_SESSION['login'] == 'admin') {
            require(__DIR__ . '/docs/add.php');
        }
        ?>
    </div>
</body>

</html>