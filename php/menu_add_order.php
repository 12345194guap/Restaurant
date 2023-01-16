<?php
session_start();
require_once 'conn_db.php';

$user_id = $_SESSION['user']["user_id"];
$products = array($_POST['products']);
$amont_products = $_POST['amont_products'];
$total_price = $_POST['total_price'];
$products = json_encode($products, JSON_UNESCAPED_UNICODE);


try {
    $sql = "SELECT user_id FROM orders WHERE user_id = '$user_id'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $check_order = $stmt->fetchColumn();
    if ($check_order) {
        echo 0;
        die();
    }
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}


try {
    $sql = "INSERT INTO orders (user_id, products, amont_products, total_price) VALUES (:user_id, :products, :amont_products, :total_price)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":user_id", $user_id);
    $stmt->bindValue(":products", $products);
    $stmt->bindValue(":amont_products", $amont_products);
    $stmt->bindValue(":total_price", $total_price);
    $stmt->execute(); 
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}

try {
    $sql = "SELECT user_id FROM orders";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $queue = $stmt->fetchAll();
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}
array_push($queue, $user_id);
echo json_encode($queue, JSON_UNESCAPED_UNICODE);

