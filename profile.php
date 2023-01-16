<?php
    session_start();
    if(isset($_SESSION['user']["auth"]) != true) {
        session_destroy();
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <title>Профиль</title>
</head>
<body>
    <div class="main">
        <div class="main_header">
            <?php echo '<h1 class="title_header">' . $_SESSION['user']["first_name"] . ' '. $_SESSION['user']["last_name"] . '</h1>' ?>
            <div class="header_btns">
                <a class="link_header" href="php/logout.php" type="button">Выйти</a>
                <a class="link_header" href="menu.php" type="button">Меню</a>
            </div>
        </div>
        <form class="form_main" method="post">
            <div class="telegram_block">
                <h2 class="telegram_title">Телеграм</h2>
                <input required autofocus class="tg_username" type="text" name="tg_username" placeholder="ID">
            </div>
            <button class="btn_main" type="submit">Сменить</button>
            <p class="msg"></p>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="js/profile.js"></script>
</body>
</html>