<?php
session_start();

use Utils\Auth;

require './../private/utils.php';
// protected-view file
$auth = new Auth;
// middleware of auth
$auth->checkUserLogged($_SESSION['userId']);

// middleware of parameters
if(!isset($_GET['id'])){
    header('location:dashboard.php?e=5');
    die();
}

use Utils\User; 
$user = new User();
$userInfo = $user->GetInfo($_SESSION['userId']);

use Utils\Notification;

$notifications = new Notification();
$notification = $notifications->get($_GET['id'], $userInfo['countryCode']);

// middleware of alerts
if(!$notification) {
    header('location:dashbard.php?e=6');
    die();
}

$notificationInfo = json_decode($notification['rawData'], true);
$street = $notifications->getStreet($notificationInfo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require realpath(__DIR__ . '/../private/templates/meta.html'); ?>
</head>

<body>
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php'); ?>
    <!-- view goes here -->

    <br>
    <h1>Details of Alert in <?php echo $street; ?></h1>
</body>

</html>