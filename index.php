<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Л/р 17</title>
</head>
<body>
    <h3>Задание №1</h3>
    
    <?php
    $i = 0;
    do {
        if ($i == 0) {
            echo "$i – это ноль.<br>";
        } elseif ($i % 2 == 0) {
            echo "$i – чётное число.<br>";
        } else {
            echo "$i – нечётное число.<br>";
        }
        $i++;
    } while ($i <= 10);
    ?>

    <h3>Задание №2</h3>
    <?php
    $regions = [
    'Московская область' => ['Москва', 'Зеленоград', 'Клин'],
    'Ленинградская область' => ['Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт'],
    'Рязанская область' => ['Рязань', 'Касимов', 'Ряжск'],
    'Тюменская область' => ['Тюмень', 'Тобольск', 'Ишим']
    ];

    foreach ($regions as $region => $cities) {
        echo "$region:<br>";
        echo implode(', ', $cities) . ".<br><br>";
    }
    ?>
    
    <h3>Задание №3</h3>
    <?php

   function transliterate($str) {
    $translit = [
        'а' => 'a',   'б' => 'b',   'в' => 'v',   'г' => 'g', 'д' => 'd',   'е' => 'e',   'ё' => 'yo',  'ж' => 'zh',
        'з' => 'z',   'и' => 'i',   'й' => 'y',   'к' => 'k', 'л' => 'l',   'м' => 'm',   'н' => 'n',   'о' => 'o',
        'п' => 'p',   'р' => 'r',   'с' => 's',   'т' => 't', 'у' => 'u',   'ф' => 'f',   'х' => 'h',   'ц' => 'ts',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch', 'ъ' => '', 'ы' => 'y',   'ь' => "'",    'э' => 'e',   'ю' => 'yu', 'я' => 'ya'
    ];

    $str = mb_strtolower($str, 'UTF-8');
    $result = '';
    for ($i = 0; $i < mb_strlen($str); $i++) {
        $char = mb_substr($str, $i, 1);
        $result .= $translit[$char] ?? $char;
    }

    return $result;
    }?>
    <p>Прикладная информатика:</p> <?php
    echo transliterate("Прикладная информатика"); 
    ?>

    <h3>Задание №4</h3>
    <?php
    $menu = [
        'Главная' => '/',
        'Тюмгу' => '/',
        'Институты' => [
            'ШКН' => '/',
            'ИнХИМ' => '/',
            'ФТИ' => '/'
        ],
        'Контакты' => '/'
    ];

    function dinamicMenu($menuItems) {?>
        <ul><?php
        foreach ($menuItems as $title => $link): ?>
            <li> <?php
            if (is_array($link)) {
                echo "<a href='#'>$title</a>";
                dinamicMenu($link);
            } else {
                echo "<a href='$link'>$title</a>";
            }?>
            </li><?php
        endforeach; ?>
        </ul> <?php
    }
    dinamicMenu($menu);
    ?>

    <h3>Задание №6</h3>
    <p>Города на букву К:</p>
    <?php
    foreach ($regions as $region => $cities):
        $filtered = array_filter($cities, function($city) {
            return mb_substr($city, 0, 1, 'UTF-8') === 'К';
        });

        if (!empty($filtered)) {
            echo "$region:<br>";
            echo implode(', ', $filtered) . ".<br><br>";
        }

    endforeach
    ?>
</body>
</html>