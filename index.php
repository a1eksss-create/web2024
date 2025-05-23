<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Л/р 17</title>
</head>
<body>
    <h3>Задание №1</h3>
    
    <?php
    $a = 6;
    $b = -3;
    echo "Число a = $a, число b = $b <br>";

    if ($a >= 0 && $b >= 0) {
        echo "Разность чисел: " . ($a - $b) . "<br>";
    } elseif ($a < 0 && $b < 0) {
        echo "Произведение чисел: " . ($a * $b) . "<br>";
    } else {
        echo "Сумма чисел: " . ($a + $b) . "<br>";
    }
    ?>

    <h3>Задание №2</h3>
    <?php
    $a = rand(0, 15);

    echo "Число a = $a <br> Числа от $a до 15:<br>";

    switch ($a) {
        case 0: echo "0 ";
        case 1: echo "1 ";
        case 2: echo "2 ";
        case 3: echo "3 ";
        case 4: echo "4 ";
        case 5: echo "5 ";
        case 6: echo "6 ";
        case 7: echo "7 ";
        case 8: echo "8 ";
        case 9: echo "9 ";
        case 10: echo "10 ";
        case 11: echo "11 ";
        case 12: echo "12 ";
        case 13: echo "13 ";
        case 14: echo "14 ";
        case 15: echo "15 ";
    }
    ?>
    
    <h3>Задание №3</h3>
    <?php

    function add($x, $y) {
        return $x + $y;
    }

    function subtract($x, $y) {
        return $x - $y;
    }

    function multiply($x, $y) {
        return $x * $y;
    }

    function divide($x, $y) {
        if ($y == 0) return "Делить на ноль нельзя";
        return $x / $y;
    }

    $a = rand(-100, 100);
    $b = rand(-100, 100);
    echo "Число a = $a, число b = $b <br>";
    echo "Сложение чисел:" . add($a, $b) . "<br>";
    echo "Вычитание чисел:" . subtract($a, $b) . "<br>";
    echo "Произведение чисел:" . multiply($a, $b) . "<br>";
    echo "Деление чисел:" . divide($a, $b) . "<br>";
    ?>

    <h3>Задание №4</h3>
    <?php
    function mathOperation($arg1, $arg2, $operation) {
        switch ($operation) {
            case 'плюс':
                return add($arg1, $arg2);
            case 'минус':
                return subtract($arg1, $arg2);
            case 'умножить':
                return multiply($arg1, $arg2);
            case 'разделить':
                return divide($arg1, $arg2);
            default:
                return "Неизвестная операция";
        }
    }
    $arg1 = rand(-100, 100);
    $arg2 = rand(-100, 100);
    $oper = 'минус';
    echo "Первый аргумент = $arg1, второй аргумент = $arg2, операция $oper <br>";

    $result = mathOperation($arg1, $arg2, $oper);
    echo "mathOperation: $result";
    ?>

    <h3>Задание №5</h3>
    <?php
    echo "1 способ череp date(): " . date("Y") . "<br>";

    $now = new DateTime();
    echo "2 способ через DateTime: " . $now->format('Y') . "<br>";

    echo "3 способ через idate(): " . idate("Y");
    ?>

    <h3>Задание №6</h3>
    <?php
    function power($val, $pow) {
        if ($pow == 0) return 1;
        if ($pow > 0) return $val * power($val, $pow - 1);
        else return 1 / power($val, -$pow);
    }

    echo "2 в степени 3 = " . power(2, 3) . "<br>";
    echo "16 в степени -2 = " . power(16, -2);
    ?>
</body>
</html>