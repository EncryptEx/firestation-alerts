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
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/timeline.css">
    <style>
        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php require realpath(__DIR__ . '/../private/templates/navbar.php'); ?>
    <!-- dashboard goes here -->
    <div class="container">
        <br>
        <h1>Watching all alerts in <?php echo $country->GetCountryName($userInfo['countryCode']); ?></h1>
        <h4 id="idleText">Looking for new notifications <span id="animated">.</span></h4>
        <div id="alertBox" class="alert alert-danger row" style="display:none;">
            <div class="col-8 col-md-5">
                <h2 id="alertBoxText" class="bold">New Alert!</h2>
                <p id="alertBoxDescText" class="bold"></p>
                <span class="material-symbols-outlined align-middle d-inline">location_on</span>
                <h5 id="locationGPS" class="d-inline align-middle">
                    Location
                </h5>
                <br>
                <br>
                <span class="material-symbols-outlined align-middle d-inline">location_on</span>
                <h5 id="location" class="d-inline align-middle">
                    Location
                </h5>
                <br>
                <br>
                <span class="material-symbols-outlined align-middle d-inline">local_fire_department</span>
                <h5 id="temperature" class="d-inline-block align-middle">
                    Temp
                </h5>
            </div>
            <div class="col-4 col-md-4" id="map-box">
                <div id="osm-map"></div>
            </div>
            <div class="col-12 col-md-3 text-md-end">
                <a href="" class="btn btn-danger text-start m-1" style="width: 160px;">
                    <span class="material-symbols-outlined align-middle">
                        fire_truck
                    </span> Call Firestation</a>
                <a href="" class="btn btn-warning text-start m-1" style="width: 160px;">
                    <span class="material-symbols-outlined align-middle">
                        notification_important
                    </span> Send Alert</a>
                <a href="" class="btn btn-light text-start m-1" style="width: 160px;">
                    <span class="material-symbols-outlined align-middle">
                        notifications_paused
                    </span> Ignore for now</a>

            </div>
            <script>
                // script to animate the loading dots
                var step = 0;
                var animated = document.getElementById('animated');
                var animationVar = setInterval(animation, 450);

                function animation() {
                    step++;
                    if (step == 1) {
                        animated.innerHTML = "."
                    }
                    if (step == 2) {
                        animated.innerHTML = ".."
                    }
                    if (step == 3) {
                        animated.innerHTML = "..."
                        step = 0;
                    }
                }
            </script>

            <script>
                // script to look up for new notifications
                // reloads when the returned value is true
                start('ws://127.0.0.1:8080');
                var text = document.getElementById('idleText');
                var alertBox = document.getElementById('alertBox');
                var alertBoxText = document.getElementById('alertBoxText');
                var locationText = document.getElementById('location');
                var GPSlocationText = document.getElementById('locationGPS');
                var tempText = document.getElementById('temperature');
                var warningIcon = "<span class='material-symbols-outlined align-middle'>warning</span>";

                function start(websocketServerLocation) {
                    ws = new WebSocket(websocketServerLocation);
                    ws.onopen = function(e) {
                        console.log("Connection established!");
                    };
                    ws.onmessage = function(e) {
                        console.log('message received:' + e.data);
                        var realdata = JSON.parse(e.data);
                        clearInterval(animationVar);
                        var lat = realdata.coords.lat;
                        var lon = realdata.coords.lon;
                        loadMap(lat, lon);
                        // thanks geocode.maps.co
                        // retireve city 
                        var coordsInfo = JSON.parse(httpGet(`https://geocode.maps.co/reverse?lat=${lat}&lon=${lon}`));
                        locationText.innerHTML = htmlentities(coordsInfo.display_name);
                        GPSlocationText.innerHTML = "GPS coords: " + htmlentities(lat) + ", " + htmlentities(lon);
                        // hide loading text
                        text.style.display = "none";
                        // insert title
                        alertBoxText.innerHTML = warningIcon + " New Alert!";
                        // add temerature
                        tempText.innerHTML = htmlentities(realdata.temp) + "ºC";
                        // add 
                        alertBoxDescText.innerHTML = "Recieved at " + new Date(htmlentities(realdata.timestamp) * 1000);
                        alertBox.style.display = "flex";
                    };
                    ws.onclose = function() {
                        console.error("Connection ended!");
                        // Try to reconnect in 5 seconds
                        setTimeout(function() {
                            start(websocketServerLocation)
                        }, 2000);
                    };
                }

                function htmlentities(t) {
                    return String(t).replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
                        return '&#' + i.charCodeAt(0) + ';';
                    });
                }
            </script>

            <script>
                function closeNotification() {
                    var animationVar = setInterval(animation, 450);
                    var div = document.getElementById("osm-map");
                    div.parentNode.removeChild(div);
                    var div = document.createElement("div");
                    document.getElementById("map-box").appendChild(div);

                }
            </script>

            <script>
                // Script to load the map
                function loadMap(lat, lng) {
                    // Where you want to render the map.
                    var element = document.getElementById('osm-map');

                    // Height has to be set. You can do this in CSS too.
                    element.style = 'width:auto;height:200px;';

                    // Create Leaflet map on map element.
                    var map = L.map(element);

                    // Add OSM tile layer to the Leaflet map.
                    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    // Target's GPS coordinates.
                    var target = L.latLng(lat, lng);

                    // Set map's center to target with zoom 14.
                    map.setView(target, 14);

                    // Place a marker on the same location.
                    L.marker(target).addTo(map);
                }
            </script>
            <script>
                function httpGet(theUrl) {
                    var xmlHttp = new XMLHttpRequest();
                    xmlHttp.open("GET", theUrl, false); // false for synchronous request
                    xmlHttp.send(null);
                    return xmlHttp.responseText;
                }
            </script>

        </div>
        <?php

        use Utils\Notification;

        $notifications = new Notification();
        $notifications = $notifications->getAll($userInfo['countryCode']);
        if (count($notifications) > 0) { ?>
            <h2>Lastest Alerts</h2>
            <div class="ccontainer">
                <!-- thanks https://codepen.io/hassan-kamal/pen/NNvYEQ -->
                <?php foreach ($notifications as $alert) { ?>
                    <div class="timeline-block timeline-block-right">
                        <div class="marker"></div>
                        <div class="timeline-content">
                            <h3>Alert nº<?php echo $alert['id']; ?></h3>
                            <span></span>
                            <p></p>
                            
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
</body>

</html>