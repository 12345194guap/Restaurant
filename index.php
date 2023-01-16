<?php
    session_start();
    require_once 'php/messages.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <title>Вход</title>
</head>
<body>
    <div class="main">
        <form class="form_main" action="php/sign_in.php" method="post">
            <h1 class="title_form">ВХОД</h1>
            <input required autofocus class="mail" type="text" name="mail" placeholder="Почта...">
            <input required class="pass" type="password" name="pass" placeholder="Пароль...">
            <div class="form_buttons">
                <button class="btn_form" type="submit">Войти</button>
                <a class="link_form" href="register.php">Регистрация</a>
            </div>
            <?php message(); ?>
        </form>
    </div>
</body>
</html>