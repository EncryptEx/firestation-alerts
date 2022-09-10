<?php
session_start();

use Utils\Auth;

require './../private/utils.php';
// protected-view file
$auth = new Auth;
$auth->checkUserLogged($_SESSION['userId']);

use Utils\User;

$user = new User;
$userInfo = $user->GetInfo($_SESSION['userId']);

use Utils\CountryHelper;

$country = new CountryHelper;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require realpath(__DIR__ . '/../private/templates/meta.html'); ?>
</head>

<body>
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php'); ?>
    <!-- dashboard goes here -->
    <div class="container">
        <br>
        <h1>Watching all alerts in <?php echo $country->GetCountryName($userInfo['countryCode']); ?></h1>
        <?php
        ?>

    </div>
</body>

</html>