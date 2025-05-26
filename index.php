<?php
$server = "localhost"; 
$user = "root";
$pass = ""; 
$database = "menu";

try {
    $db = new PDO("mysql:host=$server;dbname=$database", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Не удалось подключиться к базе: " . $e->getMessage());
}

function make_menu_tree($db, $parent = NULL) {
    $menu_list = []; 

    if ($parent === NULL) {
        $query = $db->prepare("SELECT id, name, parent_id, hasChildren FROM menuItem WHERE parent_id IS NULL");
        $query->execute();
    } else {
        $query = $db->prepare("SELECT id, name, parent_id, hasChildren FROM menuItem WHERE parent_id = :parent");
        $query->execute(['parent' => $parent]);
    }

    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $menu_item = [
            'id' => $row['id'],
            'name' => $row['name'], 
            'hasChildren' => $row['hasChildren'], 
            'items' => []
        ];

        if ($row['hasChildren']) {
            $menu_item['items'] = make_menu_tree($db, $row['id']);
        }

        $menu_list[] = $menu_item;
    }

    return $menu_list;
}

function show_menu($menu_list) {
    $html = '';

    foreach ($menu_list as $menu_item) {
        $html .= '<div class="list-item" data-parent>'; 
        $html .= '<div class="list-item__inner">';

        $html .= '<div class="list-item__arrow-container">';
        if ($menu_item['hasChildren']) {
            $html .= '<img class="list-item__arrow" src="img/chevron-down.png" alt="chevron-down" data-open>';
        }
        $html .= '</div>';

        $html .= '<img class="list-item__folder" src="img/folder.png" alt="folder">';
        $html .= '<span class="list-item__text">' . htmlspecialchars($menu_item['name']) . '</span>';
        $html .= '</div>';

        if ($menu_item['hasChildren']) {
            $html .= '<div class="list-item__items">';
            $html .= show_menu($menu_item['items']);
            $html .= '</div>';
        }

        $html .= '</div>';
    }

    return $html;
}

$menu = make_menu_tree($db);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Меню</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="list-items">
        <?= show_menu($menu) ?>
    </div>
<script src="app.js"></script>
</body>
</html>
<?php
$db = null; 
?>