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
    <link rel="stylesheet" href="./assets/css/timeline.css">
    <style>
        .bold {
            font-weight: bold;
        }
        a.btn.text-start.m-1 {
            width: 160px;
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
        <div id="alertBoxParent"></div>
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
                <div id="alert-map"></div>
            </div>
            <div class="col-12 col-md-3 text-md-end">
                <a href="" class="btn btn-danger text-start m-1">
                    <span class="material-symbols-outlined align-middle">
                        fire_truck
                    </span> Call Firestation</a>
                <a href="" class="btn btn-warning text-start m-1">
                    <span class="material-symbols-outlined align-middle">
                        notification_important
                    </span> Send Alert</a>
                <a href="" class="btn btn-light text-start m-1">
                    <span class="material-symbols-outlined align-middle">
                        notifications_paused
                    </span> Ignore for now</a>

            </div>
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
            // appends a new alert in dashboard
            start('ws://127.0.0.1:8080');
            var c = 0;

            function start(websocketServerLocation) {
                ws = new WebSocket(websocketServerLocation);
                ws.onopen = function(e) {
                    console.log("Connection established!");
                };
                ws.onmessage = function(e) {
                    c++;
                    console.log('message received:' + e.data);
                    var realdata = JSON.parse(e.data);
                    if (realdata.country_code == "UNABLE") {} else if (realdata.country_code != "<?php echo $userInfo['countryCode']; ?>") {
                        return;
                        // skip alert if is in other country
                    }
                    var lat = realdata.coords.lat;
                    var lon = realdata.coords.lon;
                    console.log('actual alert:' + e.data);
                    clearInterval(animationVar);
                    
                    var description  = "Recieved at " + new Date(htmlentities(realdata.timestamp) * 1000);
                    
                    var mapdivId = createAlert(description, lat, lon, realdata.street, realdata.temp, c);
                    
                    loadMap(lat, lon, mapdivId, 'width:auto;height:300px;', 10);
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

            function createAlert(description, lat, lon, address, temp, alertId) {
                var parent = document.getElementById('alertBoxParent');
                var alertBox = document.createElement("div");
                alertBox.classList.add('alert', 'alert-danger', 'row');
                parent.appendChild(alertBox);

                var col1info = document.createElement("div");
                var col2map = document.createElement("div");
                var col3btns = document.createElement("div");
                
                alertBox.appendChild(col1info);
                alertBox.appendChild(col2map);
                alertBox.appendChild(col3btns);


                col1info.classList.add('col-8', 'col-md-5');
                col2map.classList.add('col-4', 'col-md-4');
                col3btns.classList.add('col-12' ,'col-md-3', 'text-md-end');
                
                //left part, all info here
                var h2Title = document.createElement("h2");
                h2Title.innerHTML = "<span class=\"material-symbols-outlined align-middle d-inline\">warning</span>  New Alert!";
                h2Title.classList.add('bold');
                col1info.appendChild(h2Title);
                
                var pDesc = document.createElement("p");
                pDesc.classList.add('bold');
                pDesc.innerHTML = description;
                col1info.appendChild(pDesc);

                var divCoords = document.createElement("div");
                divCoords.classList.add('mb-4');
                col1info.appendChild(divCoords);
                divCoords.innerHTML = "<span class=\"material-symbols-outlined align-middle d-inline\">location_on</span>";
                var h5Coords = document.createElement("h5");
                h5Coords.classList.add('d-inline', 'align-middle');
                h5Coords.innerText = "  GPS coords: " + lat + ", " + lon;
                divCoords.appendChild(h5Coords);
                
                var divAddress = document.createElement("div");
                divAddress.classList.add('mb-4');
                col1info.appendChild(divAddress);
                divAddress.innerHTML = "<span class=\"material-symbols-outlined align-middle d-inline\">location_on</span>";
                var h5Address = document.createElement("h5");
                h5Address.classList.add('d-inline', 'align-middle');
                h5Address.innerText = "  " + address;
                divAddress.appendChild(h5Address);
               
               
                var divTemp = document.createElement("div");
                divTemp.classList.add('mb-4');
                col1info.appendChild(divTemp);
                divTemp.innerHTML = "<span class=\"material-symbols-outlined align-middle d-inline\">local_fire_department</span>";
                var h5Temp = document.createElement("h5");
                h5Temp.classList.add('d-inline', 'align-middle');
                h5Temp.innerText = "  " + temp + "ºC";
                divTemp.appendChild(h5Temp);
                
                // map section
                var mapDivId = 'alert-map'+alertId;
                var divMap = document.createElement("div");
                divMap.setAttribute("id", mapDivId);
                col2map.appendChild(divMap);
                
                // button section
                var aFireStation = document.createElement("a");
                aFireStation.classList.add('btn', 'btn-danger', 'text-start', 'm-1')
                aFireStation.innerHTML = "<span class=\"material-symbols-outlined align-middle d-inline\">fire_truck</span>   Call Firestation</a>";
                col3btns.appendChild(aFireStation);
                
                var aSendAlert = document.createElement("a");
                aSendAlert.classList.add('btn', 'btn-warning', 'text-start', 'm-1')
                aSendAlert.innerHTML = "<span class=\"material-symbols-outlined align-middle d-inline\">notification_important</span> Send Alert</a>";
                col3btns.appendChild(aSendAlert);
                
                var aSnooze = document.createElement("a");
                aSnooze.classList.add('btn', 'btn-light', 'text-start', 'm-1')
                aSnooze.innerHTML = "<span class=\"material-symbols-outlined align-middle d-inline\">notifications_paused</span> Ignore for now</a>";
                col3btns.appendChild(aSnooze);
                
                return mapDivId;
            }
        </script>

        <script>
            function closeNotification() {
                var animationVar = setInterval(animation, 450);
                var div = document.getElementById("alert-map");
                div.parentNode.removeChild(div);
                var div = document.createElement("div");
                document.getElementById("map-box").appendChild(div);

            }
        </script>

        <script src="./assets/js/map.js"></script>
     
        <br>
        <?php

        use Utils\Notification;

        $notificationsClass = new Notification();
        $notifications = $notificationsClass->getAll($userInfo['countryCode']);
        if (count($notifications) > 0) { ?>
            <h2>Lastest Alerts</h2>
            <div class="ccontainer">
                <!-- thanks https://codepen.io/hassan-kamal/pen/NNvYEQ -->
                <?php foreach ($notifications as $alert) {
                    $alertInfo = json_decode($alert['rawData'], true);

                    $city = $notificationsClass->getStreet($alertInfo);
                ?>
                    <div class="timeline-block timeline-block-right">
                        <div class="marker"></div>
                        <a class="timeline-content text-decoration-none" href="view.php?id=<?php echo htmlentities($alert['id']); ?>">
                            <div class="row">
                                <div class="col-5">
                                    <div id="mapId<?php echo htmlentities($alert['id']); ?>"></div>
                                    <script>
                                        loadMap(<?php echo htmlentities($alert['lat']) . ", " . htmlentities($alert['lon']) . ", 'mapId" . htmlentities($alert['id']) . "'"; ?>, 'width:auto;height:200px;margin-bottom:20px', 5);
                                    </script>
                                </div>
                                <div class="col-7">
                                    <h3>Alert in <?php echo $city; ?></h3>
                                    <span>Recieved at <?php echo Date("H:i:s, d M Y ", htmlentities($alert['timestamp'])); ?></span>
                                    <br>
                                    <span><span class="material-symbols-outlined align-middle d-inline text-bold">location_on</span> GPS: <?php echo htmlentities($alert['lat']) . ", " . htmlentities($alert['lon']); ?></span>
                                    <br>
                                    <span><span class="material-symbols-outlined align-middle d-inline text-bold">local_fire_department</span> <?php echo htmlentities($alert['temp']); ?>ºC</span>
                                    <p></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
</body>

</html>