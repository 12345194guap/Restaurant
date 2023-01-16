<?php
require_once 'conn_db.php';

try {
    $sql = "SELECT COUNT(*) FROM menu";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if ($result = $stmt->fetchColumn() == 0) {
        echo 1;
        exit();
    }

    $sql = "SELECT * FROM menu";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $menu = $stmt->fetchAll();
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    echo 1;
    die();
}

$json_data = $menu;
echo json_encode($json_data, JSON_UNESCAPED_UNICODE);
