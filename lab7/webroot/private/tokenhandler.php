<?php
include_once __DIR__ . '/sql.php';

class TokenHandler
{
    private static function erase()
    {
        setcookie('token', '', -1);
    }

    public static function check()
    {
        if (isset($_COOKIE['token']) && strlen($_COOKIE['token']) == 32) {
            if ($result = SQL::runQuery(
                'SELECT ID FROM token WHERE value = ? AND expires > NOW()',
                's',
                $_COOKIE['token']
            )) {
                $row = SQL::sqlResultFirstRow($result);
                if (isset($row['ID'])) {
                    SQL::runQuery(
                        'UPDATE token SET expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE ID = ?',
                        'i',
                        $row['ID']
                    );
                    if ($result = SQL::runQuery(
                        'SELECT (UNIX_TIMESTAMP(expires) + 10800) AS expires FROM token WHERE id = ?',
                        'i',
                        $row['ID']
                    )) {
                        $row = SQL::sqlResultFirstRow($result);
                        setcookie('token', $_COOKIE['token'], $row['expires']);
                        return true;
                    }
                }
            }
        }
        TokenHandler::erase();

        return false;
    }

    public static function create(int $userid)
    {
        $token = bin2hex(random_bytes(16));
        SQL::runQuery(
            'INSERT INTO token (ID_user, value, expires) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))',
            'is',
            $userid,
            $token
        );
        if ($result = SQL::runQuery(
            'SELECT (UNIX_TIMESTAMP(expires) + 10800) AS expires FROM token WHERE value = ?',
            's',
            $token
        )) {
            $row = SQL::sqlResultFirstRow($result);
            setcookie('token', $token, $row['expires']);
            return true;
        }
        return false;
    }

    public static function invalidate(string $value)
    {
        SQL::runQuery(
            "UPDATE token SET expires = NOW() WHERE value = ?",
            's',
            $value
        );
    }
}
