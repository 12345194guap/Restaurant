<?php
session_start();
require_once 'conn_db.php';

$title = htmlspecialchars(trim($_POST["title"]));
$price = htmlspecialchars(trim($_POST["price"]));
$desc = htmlspecialchars($_POST["desc"]);

if (!isset($_FILES["photo"]['tmp_name'][0]) || !$title || !$price || !$desc || !is_numeric($price)) {
    echo 1;
    exit();
}
try {
    $sql = "SELECT COUNT(*) FROM menu";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchColumn();
    $id = $result + 1;
}
catch (PDOException $e) {
    $id = 1;
}

$extension = substr(strrchr(trim(strip_tags($_FILES["photo"]["name"])), '.'), 1);
$file_path = '../images/' . $id . '.' . $extension;
if (move_uploaded_file($_FILES["photo"]["tmp_name"], $file_path)) {
    echo 0;
}
else {
    echo 1;
    exit();
}

try {
    $sql = "INSERT INTO menu (title, description, price, file_path) VALUES (:title, :desc, :price, :file_path)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":desc", $desc);
    $stmt->bindValue(":price", $price);
    $stmt->bindValue(":file_path", $file_path);
    $result = $stmt->execute();
    echo 0;
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    echo 1;
    die();
}
