<?php
include __DIR__ . '/figure.php';

if (isset($_GET['arg'])) {
    $arg = $_GET['arg'];
    if (is_numeric($arg)) {
        $arg = intval($arg);
        $fig = new Figure($arg);
    }
}
?>
<html>

<head>
    <title>Lab2</title>
</head>

<body>
    <?php
    if (isset($fig)) {
        $fig->printInfo();
        print($fig->draw());
    } else {
        print('<p>Целочисленный параметр "arg"<br><br>Биты [23..0]<br><br>[0..7]: ширина<br>[8..15]: высота (равно ширине если 0)<br>[16]: 0 - эллипс, 1 - прямоугольник<br>[17..23]: цвет</p>');
    }
    ?>
</body>

</html>