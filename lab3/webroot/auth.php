<?php
require "./lib/lib.php";
safe_session_start();
if (isset($_SESSION["user"])) {
    header('Location: ./library.php');
} else {
    $title = "Авторизация";
    $action = "./lib/signin.php";
    $submit = "Войти";
    require("./docs/user.php");
}
