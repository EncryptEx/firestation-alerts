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

use function Utils\GetAppDomain;

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
        $notifications = [];// $notifications->getAll($_SESSION['userId']);
        if(count($notifications) > 0) {

        } else { ?>
        <h4>Looking for new notifications <span id="animated">.</span></h4>
        <script>
            // script to animate the loading dots
            var step = 0;
            var animated = document.getElementById('animated');
            setInterval(function() {
                step++;
                if(step == 1){
                    animated.innerHTML = "."
                }
                if(step == 2){
                    animated.innerHTML = ".."
                }
                if(step == 3){
                    animated.innerHTML = "..."
                    step = 0;
                }
            },450)
        </script>

        <script>
            // script to look up for new notifications
            // reloads when the returned value is true

            function httpGet(url)
            {
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open( "GET", url, false ); // false for synchronous request
                xmlHttp.send( null );
                return xmlHttp.responseText;
            }

            
        </script>

        <?php }
        ?>

    </div>
</body>

</html>