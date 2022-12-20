<?php
require_once __DIR__ . '/../core/sql.php';
require_once __DIR__ . '/../core/filestream.php';

class PDF
{
    private int $id, $userid, $size;
    private string $name, $alias;

    public function __construct(array $dbdata)
    {
        $this->id = $dbdata['ID'] ??  0;
        $this->userid = $dbdata['ID_user'];
        $this->size = $dbdata['size'] ?? 0;
        $this->name = $dbdata['name'];
        $this->alias = $dbdata['alias'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userid;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getName()
    {
        return htmlspecialchars($this->name);
    }

    public function getDownloadName()
    {
        $name = preg_replace(
            '~
            [<>:"/\\\|?*]|
            [\x00-\x1F]|
            [\x7F\xA0\xAD]|
            [#\[\]@!$&\'()+,;=]|
            [{}^\~`]
            ~x',
            '-',
            $this->name
        );
        $name .= '.pdf';
        return $name;
    }

    public function getIsPublic()
    {
        return $this->isPublic;
    }

    public function getHumanSize()
    {
        $v = $this->size;
        $d = 'B';
        if ($this->size > 1024) {
            $v = $this->size / 1024;
            $d = 'KB';
        }

        if ($v > 1024) {
            $v /= 1024;
            $d = 'MB';
        }
        return intval($v) . ' ' . $d;
    }

    public function getPath()
    {
        return $this->pathOverride ?? __DIR__ . '/../files/' . $this->getAlias() . '.pdf';
    }

    public function sendStream()
    {
        $stream = new FileStream($this->getPath(), 'application/pdf');
        $stream->send();
    }

    public function sendDownloadStream()
    {
        $stream = new FileStream($this->getPath(), 'application/pdf');
        $stream->send($this->getDownloadName());
    }

    private static function newAlias()
    {
        $alias = "";
        while (strlen($alias) < 8) {
            switch (rand(0, 2)) {
                case 0:
                    $alias .= rand(0, 9);
                    break;
                case 1:
                    $alias .= chr(rand(65, 90));
                    break;
                case 2:
                    $alias .= chr(rand(97, 122));
                    break;
            }
        }
        if ($stmt = SQL::runQuery(
            "SELECT COUNT(*) AS cnt FROM pdf WHERE alias = ?",
            's',
            $alias
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                if (intval($row['cnt']) > 0) {
                    return PDF::newAlias();
                }
            }
        }
        return $alias;
    }

    public static function prepare(string $name)
    {
        $user = User::getUser();
        $alias = PDF::newAlias();
        $f = new PDF([
            'ID_user' => $user->getId(),
            'name' => $name,
            'alias' => $alias
        ]);

        return $f;
    }

    public function updateSize()
    {
        return $this->size = filesize($this->getPath());
    }

    public function register()
    {
        $user = User::getUser();
        if (SQL::runQuery(
            "INSERT INTO pdf (ID_User, name, size, alias) VALUES (?, ?, ?, ?)",
            'isis',
            $user->getId(),
            $this->getName(),
            $this->updateSize(),
            $this->getAlias()
        )) {
            $this->userid = $user->getId();
            return true;
        }
        return false;
    }

    public static function getByAlias(string $alias)
    {
        $user = User::getUser();
        if ($result = SQL::runQuery(
            'SELECT * FROM pdf WHERE (ID_User = ? OR ? = 1) AND alias = ?',
            'iis',
            $user->getId(),
            $user->getId(),
            $alias
        )) {
            if ($row = SQL::sqlResultFirstRow($result)) {
                return new PDF($row);
            }
        }
        return false;
    }

    public static function getAllByUser(?int $userid = 0)
    {
        $files = [];
        $user = $userid ? User::GetUserById($userid) : User::getUser();
        if ($stmt = SQL::runQuery(
            "SELECT * FROM pdf WHERE ID_User = ?",
            'i',
            $user->getId()
        )) {
            if ($result = SQL::sqlResultToArray($stmt)) {
                foreach ($result as $row) {
                    array_push($files, new PDF($row));
                }
            }
        }

        return $files;
    }

    public function delete()
    {
        $user = User::getUser();
        if ($this->userid == $user->getID() || $user->getID() == 1) {
            if (SQL::runQuery(
                "DELETE FROM pdf WHERE alias = ?",
                's',
                $this->getAlias()
            )) {
                if (file_exists($this->getPath())) {
                    unlink($this->getPath());
                }
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    public function edit(string $name)
    {
        $user = User::getUser();
        if ($this->userid == $user->getID() || $user->getID() == 1) {
            if (SQL::runQuery(
                "UPDATE pdf SET name = ? WHERE alias = ?",
                'ss',
                $name,
                $this->getAlias()
            )) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    public static function count(User $user)
    {
        if ($stmt = SQL::runQuery(
            "SELECT COUNT(*) AS cnt FROM pdf WHERE ID_User = ?",
            'i',
            $user->getID()
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                return $row['cnt'];
            }
        }
        return -1;
    }
}
