<?php
session_start();
require_once 'conn_db.php';
require_once 'check_data.php';

$first_name = htmlspecialchars(trim($_POST['first_name']));
$last_name = htmlspecialchars(trim($_POST['last_name']));
$email = htmlspecialchars(trim($_POST['mail']));
$tg_id = htmlspecialchars(trim($_POST['telegram']));
$pass = htmlspecialchars(trim($_POST['pass']));
$repeat_pass = htmlspecialchars(trim($_POST['repeat_pass']));

try {
    $sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchColumn();
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}
if ($result > 0) {
    $_SESSION['error'] = "Email уже используется!";
    header('Location: ../register.php');
    exit();
}
else if (!check_email($email)) {
    header('Location: ../register.php');
    exit();
}
else if (!check_pass($pass)) {
    header('Location: ../register.php');
    exit();
}
else if (!is_numeric($tg_id) && $tg_id) {
    $_SESSION['error'] = "ID телеграмма указан некорректно!";
    header('Location: ../register.php');
    exit();
}
else if ($pass != $repeat_pass) {
    $_SESSION['error'] = "Пароли не совпадают!";
    header('Location: ../register.php');
    exit();
}
settype($tg_id, 'integer');
$pass = password_hash($pass, PASSWORD_BCRYPT);

if ($email == 'koshelev031@gmail.com')
{
    $status = 1;
}
else {
    $status = 0;
}

try {
    $sql = "INSERT INTO users (first_name, last_name, email, tg_id, pass, status) VALUES (:first_name, :last_name, :email, :tg_id, :pass, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":first_name", $first_name);
    $stmt->bindValue(":last_name", $last_name);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":tg_id", $tg_id);
    $stmt->bindValue(":pass", $pass);
    $stmt->bindValue(":status", $status);
    $stmt->execute();

    $_SESSION['success'] = "Вы успешно зарегистрированы!";
    header('Location: ../index.php');
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}
