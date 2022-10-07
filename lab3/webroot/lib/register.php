<?php
require "lib.php";
safe_session_start();
$login = $_POST['login'];
$passcrc = crc32($_POST['password']);
$mysqli = get_sql_connection();
$stmt = $mysqli->prepare("SELECT count(*) AS cnt FROM `user` WHERE `login` like ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_row();
if ($row[0]) {
    $_SESSION['error'] = "Пользователь {$login} уже существует";
    header('Location: ../register.php');
} else {
    $stmt = $mysqli->prepare("INSERT INTO `user` (`login`, `pwdcrc`) VALUES (?, ?)");
    $stmt->bind_param("si", $login, $passcrc);
    $stmt->execute();
    $_SESSION['login'] = $login;
    header('Location: ../library.php');
}
