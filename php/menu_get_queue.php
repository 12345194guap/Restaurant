<?php
session_start();
require_once 'conn_db.php';
$user_id = $_SESSION['user']["user_id"];

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
if ($queue) {
    array_push($queue, $user_id);
    echo json_encode($queue, JSON_UNESCAPED_UNICODE);
} else
    echo 0;