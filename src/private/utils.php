<?php 

/**
 * Main utilities document.
 * @author Jaume López (EncryptEx)
 */
namespace Utils;
# start vendors
require realpath('./../../vendor/autoload.php');

# change timezone
date_default_timezone_set('Europe/Madrid');

# import all credentials to $_ENV superglobal
require 'cred.php';

# import PDO
use PDO;

# import different modules
require 'db/Database.php';
require 'auth/Auth.php';
require 'alerts/Alerts.php';


