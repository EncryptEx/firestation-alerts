<?php
session_start();

use Utils\Auth;

require './../private/utils.php';
// protected-view file
$auth = new Auth;
// middleware of auth
$auth->checkUserLogged($_SESSION['userId']);

// middleware of parameters
if (!isset($_GET['id'])) {
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
if (!$notification) {
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
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet" />
    <style>
        #alert-map {
            height: 100%;
        }
    </style>
</head>

<body>
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php'); ?>
    <!-- view goes here -->

    <div class="container mt-4">

        <h1>Details of Alert in <?php echo $street; ?></h1>
        <div class="row mt-4">
            <div class="col-12 col-md-6" id="map-box">
                <div id="alert-map" class="img-fluid"></div>
                <script src="./assets/js/map.js"></script> <script>
                    loadMap(<?php echo $notification['lat']; ?>, <?php echo $notification['lon']; ?>, 'alert-map', 'width:auto;height:300px;', 10);
                </script>
            </div>
            <div class="col-12 col-md-6 border border-light rounded bg-light p-4 pt-0">
                <div class="mb-4 mt-4">
                    <span class="material-symbols-outlined align-middle d-inline">history</span>
                    <h5 class="d-inline align-middle">
                        <?php echo date("d M Y H:i:s", $notification['timestamp']) ?>
                    </h5>
                </div>

                <div class="mb-4">
                    <span class="material-symbols-outlined align-middle d-inline">location_on</span>
                    <h5 id="locationGPS" class="d-inline align-middle">
                        <?php echo "GPS Coords: " . $notification['lat'] . ", " . $notification['lon']; ?>
                    </h5>
                </div>

                <div class="mb-4">
                    <span class="material-symbols-outlined align-middle d-inline">location_on</span>
                    <h5 id="location" class="d-inline align-middle">
                        <?php echo date("d M Y H:i:s", $notification['timestamp']) ?>
                    </h5>
                </div>

                <div class="mb-4">
                    <span class="material-symbols-outlined align-middle d-inline">local_fire_department</span>
                    <h5 id="temperature" class="d-inline-block align-middle">
                        <?php echo htmlentities($notification['temp']); ?>ºC
                    </h5>
                </div>

                <div class="align-center text-start text-xl-center justify-content-evenly row">
                    <div class="col-12 col-xl-4"><a href="" class="btn btn-danger text-start m-1" style="width: 160px;">
                            <span class="material-symbols-outlined align-middle">
                                fire_truck
                            </span> Call Firestation</a></div>
                    <div class="col-12 col-xl-4"><a href="" class="btn btn-warning text-start m-1" style="width: 160px;">
                            <span class="material-symbols-outlined align-middle">
                                notification_important
                            </span> Send Alert</a></div>
                    <div class="col-12 col-xl-4"><a href="" class="btn btn-light text-start m-1" style="width: 160px;">
                            <span class="material-symbols-outlined align-middle">
                                notifications_paused
                            </span> Ignore for now</a></div>

                </div>
            </div>

        </div>
</body>

</html>