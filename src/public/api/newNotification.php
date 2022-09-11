<?php 
require './../../private/utils.php';

if(!isset($_GET['auth']) || !isset($_GET['lat']) || !isset($_GET['lon']) || !isset($_GET['temp'])){
    http_response_code(400);
    die('Missing parameters');
}

if($_GET['auth'] != $_ENV['API_KEY']){
    http_response_code(403);
    die('Wrong apiKey');
}

// create one time password - single use token
use Utils\Token;
$otpToken = new Token;
$key = time()."otpToken". $otpToken->Create();

// add record to db

?>

<script>
    var key = "<?php echo $key;?>";
    var encryptedKey = "<?php echo hash('SHA256', $_ENV['HASH_SALT'] . $key . $_ENV['HASH_SALT2']);?>";
    var message = '{"coords":{"lat":<?php echo addslashes($_GET["lat"]); ?>,"lon":<?php echo addslashes($_GET["lon"])?>},"temp":<?php echo addslashes($_GET["temp"]) ?>,"timestamp":<?php echo time(); ?>}';
    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established... sending data");
        conn.send("BROADCAST-ALERT "+key+" "+encryptedKey+" "+message);
    };

</script>