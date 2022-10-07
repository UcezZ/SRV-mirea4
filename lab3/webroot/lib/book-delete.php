<?php
if (isset($_POST['id'])) {
    require(__DIR__ . '/lib.php');
    $result = delete_book($_POST['id']);
    print_r($result);
    if ($result) {
        $_SESSION['error'] = "Ошибка удаления<br>$result";
    }
}
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
