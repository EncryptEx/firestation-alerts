<?php 

namespace Utils; 

class Notification
{
    public function Add($countryCode, $rawData, $lat, $lon, $temp) {
        global $pdo;

        $SQL_insert = "INSERT INTO `notification` (id, countryCode, rawData, lat, lon, temp, timestamp) VALUES (NULL, :countryCode, :rawData, :lat, :lon, :temp, :timestamp)";
        $inertStmt = $pdo->prepare($SQL_insert);
        $input =   ['countryCode'=> $countryCode, 'rawData'=>$rawData, 'lat'=> $lat, 'lon'=> $lon, 'temp'=> $temp, 'timestamp'=> time()];
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
    public function get(int $id, string $countryCode){
        global $pdo;

        $SQL_SELECT = "SELECT * FROM `notification` WHERE id=:id AND countryCode=:countryCode LIMIT 1";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['id'=> $id, 'countryCode'=> $countryCode];
        $selectStmt->execute($input);

        if ($selectStmt->rowCount() > 0) {
            return $selectStmt->FetchAll()[0];
        }
        return FALSE;
    }
    public function getStreet($entireJSONparsedData){
        $city = $entireJSONparsedData['display_name'];
        if (isset($entireJSONparsedData['address']['city']) && $entireJSONparsedData['address']['city'] != NULL) {
            $city = $entireJSONparsedData['address']['city'];
        } elseif (isset($entireJSONparsedData['address']['town']) && $entireJSONparsedData['address']['town'] != NULL) {
            $city = $entireJSONparsedData['address']['town'];
        } elseif (isset($entireJSONparsedData['address']['road']) && $entireJSONparsedData['address']['road'] != NULL) {
            $city = $entireJSONparsedData['address']['road'];
        }
        return $city;
    }
}
