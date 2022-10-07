<?php
include __DIR__ . '/qsort.php';

if (isset($_GET['arg'])) {
    $arr = explode(';', $_GET['arg']);
    foreach ($arr as $key => $value) {
        if (!is_numeric($value)) {
            $error = "Элемент с индексом $key ($value) не является числом";
            break;
        }
    }
    if (!isset($error)) {
        QuickSort::sort($arr);
    }
} else {
    $error = 'Массив должен быть задан последовательностью чисел, разделённых знаком ";", переданной в параметре "arg"';
}
?>
<html>

<head>
    <title>Быстрая сортировка</title>
</head>

<body>
    <?php
    if (isset($error)) {
        print($error);
    } else {
        print("Исходный массив: {$_GET['arg']}<br>Отсортированный массив: ");
        $lastidx = sizeof($arr) - 1;
        foreach ($arr as $key => $value) {
            print($value);
            if ($key < $lastidx) {
                print(';');
            }
        }
    }
    ?>
</body>

</html>