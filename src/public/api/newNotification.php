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

// parse data
$lat = addslashes($_GET['lat']);
$lon = addslashes($_GET['lon']);
$temp = addslashes($_GET['temp']);

// get country code and street thanks to reverse geocode https://geocode.maps.co/reverse?lat=${lat}&lon=${lon}
$opts = array(
    'http'=>array(
    'method'=>"GET",
    'header'=>"Accept: application/json\r\n"
    )
);

$context = stream_context_create($opts);
$url = 'https://geocode.maps.co/reverse?lat=' . $lat . '&lon='.$lon;

$rawData = file_get_contents($url, false, $context); 
$result = json_decode($rawData, true);
$street = $result['display_name'];
$countryCode = strtoupper($result['address']['country_code']);

// add record to db
use Utils\Notification;
$notification = new Notification;
$notification->Add($countryCode, $rawData, $lat, $lon, $temp);
?>

<script>
    var key = "<?php echo $key;?>";
    var encryptedKey = "<?php echo hash('SHA256', $_ENV['HASH_SALT'] . $key . $_ENV['HASH_SALT2']);?>";
    var message = '{"country_code":"<?php echo addslashes($countryCode); ?>","street":"<?php echo addslashes($street); ?>","coords":{"lat":<?php echo addslashes($_GET["lat"]); ?>,"lon":<?php echo addslashes($_GET["lon"])?>},"temp":<?php echo addslashes($_GET["temp"]) ?>,"timestamp":<?php echo time(); ?>}';
    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established... sending data");
        conn.send("BROADCAST-ALERT|"+key+"|"+encryptedKey+"|"+message);
    };

</script>