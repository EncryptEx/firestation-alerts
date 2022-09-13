<?php 

namespace Utils; 

class Notification
{
    public function Add($countryCode, $lat, $lon, $temp) {
        global $pdo;

        $SQL_insert = "INSERT INTO `notification` (id, countryCode, lat, lon, temp, timestamp) VALUES (NULL, :countryCode, :lat, :lon, :temp, :timestamp)";
        $inertStmt = $pdo->prepare($SQL_insert);
        $input =   ['countryCode'=> $countryCode, 'lat'=> $lat, 'lon'=> $lon, 'temp'=> $temp, 'timestamp'=> time()];
        return  $inertStmt->execute($input);
    }

    public function getAll(string $countryCode){
        global $pdo;

        $SQL_SELECT = "SELECT * FROM `notification` WHERE countryCode=:countryCode ORDER BY `timestamp` DESC";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['countryCode'=> $countryCode];
        $selectStmt->execute($input);

        if ($selectStmt->rowCount() > 0) {
            return $selectStmt->FetchAll();
        }
        return [];
    }
}
