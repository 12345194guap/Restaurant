<?php
    session_start();
    if(isset($_SESSION['user']["auth"]) != true && isset($_SESSION['user']["status"]) == 0) {
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
    <link rel="stylesheet" href="css/admin_panel.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <title>Админ панель</title>
</head>
<body>
    <div class="main">
        <header class="header">
            <h1 class="header_title">Панель администратора</h1>
            <div class="header_btns">
                <a class="header_link_exit" href="php/logout.php">Выйти</a>
                <a class="header_link_exit" href="menu.php">Меню</a>
            </div>
        </header>
        <p class="header_line"></p>
        <div class="first_level">
            <!-- Добавление -->
            <div class="supple_dish">
                <p class="msg"></p>
                <h2 class="supple_title_h2">Добавление блюда</h1>
                <form class="supple_form" method="post" enctype="multipart/form-data">
                    <div class="supple_inputs_1">
                        <input class="supple_title" type="text" name="title" placeholder="Название...">
                        <input class="supple_price" type="text" name="price" placeholder="Цена...">
                    </div>
                    <div class="supple_inputs_2">
                        <textarea class="supple_description" type="text" name="desc" placeholder="Описание..."></textarea>
                        <div class="supple_last_div">
                            <label class="input-file">
                                <span class="input-file-text" type="text"></span>
                                <input class="input-input" type="file" name="photo" accept=".jpg, .png, .jpeg">        
                                <span class="input-file-btn">Добавить фото</span>
                            </label>
                        </div>
                    </div>
                    <button class="supple_btn" type="submit">Добавить блюдо</button>
                </form>
            </div>

            <!-- Редактирование -->
            <div class="recipe_dish">
                <h2 class="recipe_title_h2">Редактирование блюда</h1>
                <div class="recipe_content">
                    <div class="choice_food">
                        <button class="choice_food_btn" type="button">Выбери блюдо</button>
                        <ul class="choice_food_list"></ul>
                    </div>
                    <div class="recipe_block">
                        <form class="recipe_form" method="post" enctype="multipart/form-data">
                            <div class="recipe_inputs_1">
                                <input class="recipe_title" type="text" name="title" placeholder="Название...">
                                <input class="recipe_price" type="text" name="price" placeholder="Цена...">
                            </div>
                            <div class="recipe_inputs_2">
                                <textarea class="recipe_description" type="text" name="desc" placeholder="Описание..."></textarea>
                                <div class="recipe_last_div">
                                    <label class="input-file">
                                        <span class="input-file-text" type="text"></span>
                                        <input class="input-input" type="file" name="photo" accept=".jpg, .png, .jpeg">        
                                        <span class="input-file-btn">Добавить фото</span>
                                    </label>
                                </div>
                            </div>
                            <button class="recipe_btn" type="submit">Подтвердить</button>
                        </form>
                    </div>
                </div>
                <p class="recipe_msg"></p>
            </div>
        </div>
        <!-- Заказ -->
        <div class="order_accept">
            <div class="order_accept_title">
                <h2 class="order_title">Подтвердить заказ</h2>
                <div class="order_accept_svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                        <path d="M20.5,8 L17,12 L19.5,12 C19.5,16.136 16.136,19.5 12,19.5 C9.473,19.5 7.238,18.24 5.878,16.318 L4.534,17.855 C6.275,20.07 8.971,21.5 12,21.5 C17.238,21.5 21.5,17.238 21.5,12 L24,12 L20.5,8 Z M7,12 L4.5,12 C4.5,7.864 7.864,4.5 12,4.5 C14.527,4.5 16.762,5.76 18.122,7.681 L19.466,6.145 C17.725,3.93 15.029,2.5 12,2.5 C6.762,2.5 2.5,6.762 2.5,12 L0,12 L3.5,16 L7,12 Z"/>
                    </svg>
                </div>
            </div>
            <div class="order_list_div">
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>