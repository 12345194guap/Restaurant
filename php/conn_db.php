<?php
$pdo = new PDO("mysql:host=localhost", "root", "root");
$sql = 'CREATE DATABASE IF NOT EXISTS cr36980_rest';
$pdo->exec($sql);

$pdo = new PDO('mysql:host=localhost;dbname=cr36980_rest;charset=utf8', 'root', 'root');
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS users(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL,
        email TEXT NOT NULL,
        tg_id BIGINT NOT NULL,
        pass VARCHAR(60) NOT NULL,
        status BOOL NOT NULL);"
    );

    $pdo->exec("CREATE TABLE IF NOT EXISTS menu(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        price REAL NOT NULL,
        file_path TEXT NOT NULL);"
    );

    $pdo->exec("CREATE TABLE IF NOT EXISTS orders(
        user_id INT NOT NULL,
        products TEXT NOT NULL,
        amont_products INT NOT NULL,
        total_price INT NOT NULL);"
    );
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}
