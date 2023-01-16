<?php
session_start();
function check_pass($val) {
    if (strlen($val) < 8) {
        $_SESSION['error'] = "Пароль содержит меньше 8 символов!";
        return false;
    }
    else if (!preg_match("#[0-9]+#", $val)) {
        $_SESSION['error'] = "Пароль должен содержать хотя бы 1 цифру!";
        return false;
    }
    else if (!preg_match("#[a-zA-Zа-яА-Я]+#", $val)) {
        $_SESSION['error'] = "Пароль должен содержать хотя бы 1 строчную и 1 заглавную букву!";
        return false;
    }
    return true;
}
function check_email($val) {
    if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Некорректный email адрес!";
        return false;
    }
    return true;
}