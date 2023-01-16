<?php
require_once 'conn_db.php';

$user_id = $_POST['user_id'];
try {
    $sql = "DELETE FROM orders WHERE user_id = '$user_id'";
    $pdo->exec($sql);
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}

$token = '5650326977:AAGGsaBi26iSqFOuG6_qy1Hf2_cUuo36G-M';

try {
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $chat_id = $stmt->fetchAll()[0]['tg_id'];
}
catch (PDOException $e) {
    print_r("[ERROR] " . $e->getMessage());
    die();
}


$txt = '✅ <b>Ваш заказ готов</b>';
$url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);

$curl_sraped_page = curl_exec($ch);
echo $user_id;