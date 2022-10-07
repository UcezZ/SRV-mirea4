<?php
require "lib.php";
safe_session_start();
$login = $_POST['login'];
$passcrc = crc32($_POST['password']);
$mysqli = get_sql_connection();
$stmt = $mysqli->prepare("SELECT * FROM `user` WHERE `login` = ? AND `pwdcrc` = ?");
$stmt->bind_param("si", $login, $passcrc);
$stmt->execute();
$check = $stmt->get_result();
if (mysqli_num_rows($check) > 0) {
	$user = $check->fetch_assoc();
	$_SESSION['login'] = $login;

	header('Location: ../library.php');
} else {
	$_SESSION['error'] = "Имя пользователя или пароль не распознаны";
	header('Location: ../auth.php');
}
