<?php 

/**
 * Main utilities document.
 * @author Jaume López (EncryptEx)
 */
namespace Utils;
# start vendors
require_once __DIR__ . '/../../vendor/autoload.php';

# change timezone
date_default_timezone_set('Europe/Madrid');

# import all credentials to $_ENV superglobal
require 'cred.php';

# import PDO
use PDO;

# import different modules and initialitze database
require 'db/Database.php';
new Database();
require 'auth/Auth.php';
require 'auth/Verification.php';
require 'auth/Token.php';
require 'ui-alerts/Alerts.php';
require 'user/User.php';
require 'countryHelper/CountryHelper.php';
require 'notifications/Notifications.php';

function GetAppDomain(){
    if (isset($_SERVER['HTTPS'])) {
        $extraS = "s";
    } else {
        $extraS = "";
    }
    return "http" . $extraS . "://" . $_SERVER['HTTP_HOST'];
}
