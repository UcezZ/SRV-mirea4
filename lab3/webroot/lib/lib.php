<?php

function safe_session_start()
{
	if (!isset($_SESSION))
		session_start();
}

function get_sql_connection()
{
	return new mysqli("mysql", "user", "password", "appDB");
}

function edit_book(int $id, string $author, string $name, string $url = '')
{
	if (strlen($author) == 0 && strlen($name) == 0 && strlen($url) == 0) {
		return false;
	}

	$mysqli = get_sql_connection();

	$result = array();

	if (strlen($author)) {
		$stmt = $mysqli->prepare("UPDATE `book` SET `author` = ? WHERE `id` = ?");
		$stmt->bind_param("si", $author, $id);
		$stmt->execute();
		if (isset($stmt->error)) {
			array_push($result, $stmt->error);
		}
	}

	if (strlen($name)) {
		$stmt = $mysqli->prepare("UPDATE `book` SET `name` = ? WHERE `id` = ?");
		$stmt->bind_param("si", $name, $id);
		$stmt->execute();
		if (isset($stmt->error)) {
			array_push($result, $stmt->error);
		}
	}

	if (strlen($url)) {
		$stmt = $mysqli->prepare("UPDATE `book` SET `url` = ? WHERE `id` = ?");
		$stmt->bind_param("si", $url, $id);
		$stmt->execute();
		if (isset($stmt->error)) {
			array_push($result, $stmt->error);
		}
	}

	return sizeof($result) ? $result : false;
}

function delete_book(int $id)
{
	$mysqli = get_sql_connection();

	$stmt = $mysqli->prepare("DELETE FROM book WHERE `id` = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();

	return isset($stmt->error) ? $stmt->error : false;
}

function add_book(string $author, string $name, string $url)
{
	if (strlen($author) == 0 || strlen($name) == 0) {
		return false;
	}
	$mysqli = get_sql_connection();

	$stmt = $mysqli->prepare("INSERT INTO `book` (`author`, `name`, `url`) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $author, $name, $url);
	$stmt->execute();
	print($stmt->error);

	return isset($stmt->error) ? $stmt->error : false;
}

function get_books()
{
	$mysqli = get_sql_connection();

	$result = $mysqli->query("SELECT * FROM book");

	return $result->fetch_all(MYSQLI_ASSOC);
}
