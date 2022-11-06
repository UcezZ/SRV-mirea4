<?php
include_once __DIR__ . '/sql.php';

class User
{
    private int $id;
    private string $locale, $login, $theme;

    public function __construct(array $dbdata)
    {
        $this->id = $dbdata['ID'];
        $this->login = $dbdata['login'];
        $this->locale = $dbdata['locale'];
        $this->theme = $dbdata['theme'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    private static function checkUserExists(string $login)
    {
        if ($stmt = SQL::runQuery(
            'SELECT COUNT(*) AS cnt FROM user WHERE login like ?',
            's',
            $login
        )) {
            if ($result = SQL::sqlResultFirstRow($stmt)) {
                if (isset($result['cnt'])) {
                    return $result['cnt'] > 0;
                }
            }
        }
    }

    public static function register(string $login, string $password)
    {
        if (User::checkUserExists($login)) {
            return false;
        }

        $pwdhash = crc32($password);

        if (SQL::runQuery(
            "INSERT INTO user (login, pwdcrc, locale) VALUES (?, ?, ?)",
            'si',
            $login,
            $pwdhash,
            Locale::parseBrowserLocale()
        )) {
            return true;
        }
        return false;
    }

    public function changePassword(string $oldPassword, string $newPassword)
    {
        $pwdcrc = crc32($oldPassword);

        if ($result = SQL::sqlResultFirstRow(SQL::runQuery(
            'SELECT COUNT(*) AS cnt from user WHERE ID = ? AND pwdcrc = ?',
            'ii',
            $this->getId(),
            $pwdcrc
        ))) {
            if ($result['cnt'] == 0) {
                return 1;
            }
        }

        $pwdcrc = crc32($newPassword);

        if (SQL::runQuery(
            'UPDATE user SET pwdcrc = ? WHERE ID = ?',
            'ii',
            $pwdcrc,
            $this->getId()
        )) {
            return 0;
        }
        return 2;
    }

    public static function login(string $login, string $password)
    {
        $pwdhash = crc32($password);
        if ($result = SQL::runQuery(
            "SELECT ID FROM user WHERE login = ? AND pwdcrc = ?",
            'si',
            $login,
            $pwdhash
        )) {
            if ($row = SQL::sqlResultFirstRow($result)) {
                if (isset($row['ID'])) {
                    return TokenHandler::create($row['ID']);
                }
            }
        }
        return false;
    }

    public static function logout()
    {
        while (TokenHandler::check()) {
            TokenHandler::invalidate($_COOKIE['token']);
        }
    }

    public static function getUser()
    {
        if (isset($_COOKIE['token'])) {
            if ($stmt = SQL::runQuery(
                'SELECT user.* FROM user JOIN token ON user.ID = token.ID_User AND token.value = ?',
                's',
                $_COOKIE['token']
            )) {
                if ($row = SQL::sqlResultFirstRow($stmt)) {
                    $user = new User($row);
                    return $user;
                }
            }
        }
    }

    public static function getUserById(int $userid)
    {
        if ($stmt = SQL::runQuery(
            'SELECT * FROM user WHERE ID = ?',
            'i',
            $userid
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                $user = new User($row);
                return $user;
            }
        }
    }

    public function edit(string $locale, string $theme)
    {
        $locale = Locale::gatherLocale($locale);
        $theme = Theme::gatherTheme($theme);

        return (bool) SQL::runQuery(
            'UPDATE user SET locale = ?, theme = ? WHERE ID = ?',
            'ssi',
            $locale,
            $theme,
            $this->getId()
        );
    }
}
