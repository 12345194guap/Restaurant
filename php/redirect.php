<?php
session_start();
if ($_SESSION['user']["status"] == "0") header('Location: ../profile.php');
else header('Location: ../admin_panel.php');