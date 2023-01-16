<?php
session_start();
require_once 'funcs.php';
require_once 'conn_db.php';

$title = htmlspecialchars(trim($_POST["title"]));
$price = htmlspecialchars(trim($_POST["price"]));
$desc = htmlspecialchars($_POST["desc"]);
$id = $_POST["id"];

if (!$title && !$price && !$desc && !isset($_FILES['photo']['tmp_name'][0]) && !is_numeric($price)) {
    echo 1;
    exit();
}

$sql = "SELECT * FROM menu WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
$stmt->execute();
$get_sql = $stmt->fetchAll()[0];

if (isset($_FILES['photo']['tmp_name'][0])) {
    unlink($get_sql['file_path']);
    $extension = substr(strrchr(trim(strip_tags($_FILES["photo"]["name"])), '.'), 1);
    $file_path = '../images/' . $id . '.' . $extension;
}
else {
    $extension = substr(strrchr(trim(strip_tags($get_sql['file_path'])), '.'), 1);
    $file_path = '../images/' . $id . '.' . $extension;
}


if ($price == 0)
    $price = $get_sql['price'];

move_uploaded_file($_FILES["photo"]["tmp_name"], $file_path);
$arr_post = array(
    'key_title' => $title,
    'key_description' => $desc,
    'key_price' => $price,
    'key_file_path' => $file_path
);

$arr_db = array(
    'key_title' => '',
    'key_description' => '',
    'key_price' => '',
    'key_file_path' => ''
);

$arr_db["key_title"] = $get_sql['title'];
$arr_db["key_description"] = $get_sql['description'];
$arr_db["key_price"] = $get_sql['price'];
$arr_db["key_file_path"] = $get_sql['file_path'];


array_map(function ($key, $value) {
    global $arr_db;
    if ($value != null || $value != "") {
        return $arr_db[$key] = $value;
    }
}, array_keys($arr_post),  $arr_post);

try {
    $sql = "UPDATE menu SET title = :title, description = :description, price = :price, file_path = :file_path WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":title", $arr_db['key_title']);
    $stmt->bindValue(":description", $arr_db['key_description']);
    $stmt->bindValue(":price", $arr_db['key_price']);
    $stmt->bindValue(":file_path", $arr_db['key_file_path']);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    echo 0;
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    echo 1;
    die();
}
