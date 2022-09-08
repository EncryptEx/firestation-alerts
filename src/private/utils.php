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
require 'alerts/Alerts.php';

