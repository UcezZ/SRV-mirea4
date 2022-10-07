<?php
if (isset($_POST['author']) && isset($_POST['name'])) {
    require(__DIR__ . '/lib.php');
    $result = add_book($_POST['author'], $_POST['name'], $_POST['url']);
    if ($result) {
        $_SESSION['error'] = "Ошибка добавления<br>$result";
    }
}
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
