<?php

session_start();
require_once 'conn_db.php';


$email = htmlspecialchars(trim($_POST['mail']));
$pass = htmlspecialchars(trim($_POST['pass']));
try {
    $sql = "SELECT pass FROM users WHERE email = '$email'";
    $stmt = $pdo->query($sql);
    $stmt->execute();
    $pass_hash = $stmt->fetchAll()[0]['pass'];
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}

if (password_verify($pass, $pass_hash)) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $check_user = $stmt->fetchAll();
    if($check_user > 0) {
        $_SESSION['user'] = [
            "user_id" => $check_user[0]['id'],
            "first_name" => $check_user[0]['first_name'],
            "last_name" => $check_user[0]['last_name'],
            "email" => $check_user[0]['email'],
            "status" => $check_user[0]['status'],
            "auth" => true
        ];
        header('Location: ../menu.php');
        exit();
    }
    else {
        $_SESSION['error'] = "Произошла ошибка...";
        header('Location: ../index.php');
        exit();
    }
}
else {
    $_SESSION['error'] = "Некорректные почта или пароль!";
    header('Location: ../index.php');
}
