<?php
$server = "localhost"; 
$user = "root"; 
$pass = ""; 
$database = "menu";

try {
    $db = new PDO("mysql:host=$server;dbname=$database", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "error" => "Не удалось подключиться: " . $e->getMessage()]);
    exit();
}

function doFeedbackAction($db, $action, $data) {
    $result = ["success" => false, "error" => ""]; 

    $months = [
        1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
        5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
        9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
    ];

    if ($action == "create") {
        $product_id = isset($data['product_id']) ? $data['product_id'] : 0;
        $user_name = isset($data['user_name']) ? $data['user_name'] : '';
        $comment = isset($data['comment']) ? $data['comment'] : '';
        if ($product_id && $user_name && $comment) {
            $query = $db->prepare("INSERT INTO feedback (product_id, user_name, comment) VALUES (:product_id, :user_name, :comment)");
            $query->execute([
                'product_id' => $product_id,
                'user_name' => $user_name,
                'comment' => $comment
            ]);
            $result["success"] = true;
        } else {
            $result["error"] = "Заполните все поля!";
        }
    } elseif ($action == "read") {
        $product_id = isset($data['product_id']) ? $data['product_id'] : 0;
        $query = $db->prepare("SELECT id, name, image, price, description FROM products WHERE id = :id");
        $query->execute(['id' => $product_id]);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        if ($product) {
            $query = $db->prepare("SELECT id, user_name, comment, created_at FROM feedback WHERE product_id = :product_id ORDER BY created_at DESC");
            $query->execute(['product_id' => $product_id]);
            $feedback = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($feedback as &$item) {
                $date = new DateTime($item['created_at']);
                $day = $date->format('j'); 
                $month = $months[(int)$date->format('n')]; 
                $year = $date->format('Y');
                $time = $date->format('H:i'); 
                $item['created_at'] = "$day $month $year, $time"; 
            }
            unset($item); 
            $result["success"] = true;
            $result["product"] = $product;
            $result["feedback"] = $feedback ? $feedback : [];
        } else {
            $result["error"] = "Товар с ID $product_id не найден!";
        }
    } elseif ($action == "update") {
        $id = isset($data['id']) ? $data['id'] : 0;
        $user_name = isset($data['user_name']) ? $data['user_name'] : '';
        $comment = isset($data['comment']) ? $data['comment'] : '';
        if ($id && $user_name && $comment) {
            $query = $db->prepare("UPDATE feedback SET user_name = :user_name, comment = :comment WHERE id = :id");
            $query->execute([
                'id' => $id,
                'user_name' => $user_name,
                'comment' => $comment
            ]);
            $result["success"] = true;
        } else {
            $result["error"] = "Заполните все поля!";
        }
    } elseif ($action == "delete") {
        $id = isset($data['id']) ? $data['id'] : 0;
        if ($id) {
            $query = $db->prepare("DELETE FROM feedback WHERE id = :id");
            $query->execute(['id' => $id]);
            $result["success"] = true;
        } else {
            $result["error"] = "ID отзыва не указан!";
        }
    } else {
        $result["error"] = "Неверное действие! Получено: " . ($action ? $action : "пусто");
    }

    return $result;
}

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');
$data = $_POST ?: $_GET;
header('Content-Type: application/json');
echo json_encode(doFeedbackAction($db, $action, $data));
$db = null;
?>