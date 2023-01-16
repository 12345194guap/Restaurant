<?
session_start();
require_once 'conn_db.php';

$user_id = $_SESSION['user']["user_id"];
$tg_id = $_POST['tg_id'];

if ((!is_numeric($tg_id) && $tg_id)) {
    echo 1;
    exit();
}
settype($tg_id, 'integer');
try {
    $sql = "UPDATE users SET tg_id = :tg_id WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":tg_id", $tg_id);
    $stmt->bindValue(":user_id", $user_id);
    $stmt->execute();
    echo 0;
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    echo 1;
    die();
}