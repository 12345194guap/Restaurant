<?php
session_start();
function message() {
    if (isset($_SESSION['error'])) {
        echo '<p class="error_msg"> ' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    else if (isset($_SESSION['success'])) {
        echo '<p class="success_msg"> ' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }
}