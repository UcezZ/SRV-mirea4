<?php

class SQL
{
    private static mysqli $conn;

    private static function connect()
    {
        if (!isset(SQL::$conn) || is_null(SQL::$conn)) {
            SQL::$conn = new mysqli("mysql", "user", "password", "appDB");
        }
        if (!SQL::$conn) {
            die('Unable to connect to database!');
        }
    }

    public static function sqlResultToArray(mysqli_stmt|false $stmt)
    {
        if ($stmt) {
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public static function sqlResultFirstRow(mysqli_stmt|false $stmt)
    {
        if ($stmt) {
            return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public static function runQuery(string $query, string $types = null, ...$params)
    {
        SQL::connect();
        $stmt = SQL::$conn->prepare($query);
        if (!is_null($params) && sizeof($params)) {
            $stmt->bind_param($types, ...$params);
        }
        return $stmt->execute() ? $stmt : false;
    }

    public static function getInsertedId()
    {
        return SQL::$conn ? SQL::$conn->insert_id : false;
    }

    public static function getErrors()
    {
        return SQL::$conn ? SQL::$conn->error_list : false;
    }
}
