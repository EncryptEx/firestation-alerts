<?php 

namespace Utils; 

class Notification
{
    public function Add($countryCode, $lat, $lon, $temp) {
        global $pdo;

        $SQL_SELECT = "INSERT INTO `notification` (id, countryCode, lat, lon, temp, timestamp) VALUES (NULL, :countryCode, :lat, :lon, :temp, :timestamp)";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['countryCode'=> $countryCode, 'lat'=> $lat, 'lon'=> $lon, 'temp'=> $temp, 'timestamp'=> time()];
        return  $selectStmt->execute($input);
    }
}
