<?php
require "./lib/lib.php";
safe_session_start();
if (isset($_SESSION["user"])) {
    header('Location: ./library.php');
} else {
    $title = "Регистрация";
    $action = "./lib/register.php";
    $submit = "Зарегистрироваться";
    require("./docs/user.php");
}
