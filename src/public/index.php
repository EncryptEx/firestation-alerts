<?php
session_start();
require './../private/utils.php';

use Utils\Auth;

$auth = new Auth;
$auth->checkUserNotLogged($_SESSION['userId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require realpath(__DIR__ . '/../private/templates/meta.html'); ?>
</head>
<body>
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php');?>
    <!-- hero goes here -->
</body>
</html>