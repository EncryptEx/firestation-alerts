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

<body class="text-bg-white text-black">
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php'); ?>
    <!-- hero goes here -->

    <!-- HERO -->
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">

            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3">Forestal Supervision Reimagined.</h1>
                <p class="lead">With the power of nanosatellites, fires will be detected, prevented and extinguished earlier. Join now the community of firefighters and give it a try!</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="register.php" class="btn btn-warning btn-lg px-4 me-md-2">Get started</a>
                    <a href="login.php" class="btn btn-outline-secondary btn-lg px-4">Login</a>
                </div>
            </div>
            <div class="col-10 col-sm-8 col-lg-6">
                <!-- <div class=" p-3 mb-5 bg-secondary rounded"> -->
                <img src="assets/img/nanosat.png" class="shadow-white d-block mx-lg-auto img-fluid" alt="" loading="lazy">
                <!-- </div> -->
            </div>
        </div>
    </div>

    <hr id="features">

    <!-- FEATURES -->
    <div class="container px-4 py-5">
        <h2 class="pb-2 border-bottom">Features</h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="col d-flex align-items-start">
                <div class="icon-square text-bg-white d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <span class="material-symbols-outlined">
                        timer
                    </span>
                </div>
                <div>
                    <h2>Easy to use and set up</h2>
                    <p>This tool is a useful and easy-to-use service. The registration can be done in less than five minutes with a few clicks.</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <div class="icon-square text-bg-white d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <span class="material-symbols-outlined">
                        local_fire_department
                    </span>
                </div>
                <div>
                    <h2>Fire detection with high precision</h2>
                    <p>The hardware of the nanosatellite allows it to detect with low-latency some fire issues that might supervision time.</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <div class="icon-square text-bg-white d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <span class="material-symbols-outlined">
                        fast_forward
                    </span>
                </div>
                <div>
                    <h2>Fast and reliable emergency alerts</h2>
                    <p>Alerts are sent via websockets (by default). This alerts are triggered just right after the satellite's call of its Url trigger. They are sent with encryption and a series of standards.</p>
                </div>
            </div>
        </div>
    </div>

    <hr id="installation">
    <br>
    <!-- installation -->



    </div><br>

</body>

</html>