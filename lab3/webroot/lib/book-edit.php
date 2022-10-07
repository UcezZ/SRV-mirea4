<?php
if (isset($_POST['author']) || isset($_POST['name']) || isset($_POST['url'])) {
    require(__DIR__ . '/lib.php');
    $result = edit_book($_POST['id'], $_POST['author'], $_POST['name'], $_POST['url']);
    if ($result) {
        $_SESSION['error'] = "Ошибка редактирования";
        foreach ($result as $value) {
            $_SESSION['error'] .= "<br>$result";
        }
    }
}
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
