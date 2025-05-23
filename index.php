<?php
$title = "Главная страница";
$h1 = "Сайт ТюмГУ";
$year = date("Y");

function formatTime($hours, $minutes) {
    // Обработка склонения часов
    if ($hours % 10 == 1 && $hours != 11) {
        $hour_text = "$hours час";
    } elseif (in_array($hours % 10, [2, 3, 4]) && !in_array($hours, [12, 13, 14])) {
        $hour_text = "$hours часа";
    } else {
        $hour_text = "$hours часов";
    }

    if ($minutes % 10 == 1 && $minutes != 11) {
        $minute_text = "$minutes минута";
    } elseif (in_array($minutes % 10, [2, 3, 4]) && !in_array($minutes, [12, 13, 14])) {
        $minute_text = "$minutes минуты";
    } else {
        $minute_text = "$minutes минут";
    }

    return "$hour_text $minute_text";
}

$currentTime = formatTime((int)date("H"), (int)date("i"));
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
</head>
<body>
    <h1><?=$h1?></h1>
    <p>Текущий год: <?=$year?></p>
    <p>Текущее время: <?=$currentTime?></p>
</body>
</html>