<?php
session_start();
use Utils\Auth;

require './../private/utils.php';
// protected-view file
$auth = new Auth;
$auth->checkUserLogged($_SESSION['userId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require realpath(__DIR__ . '/../private/templates/meta.html'); ?>
</head>
<body>
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php');?>
    <!-- view goes here -->
</body>
</html>