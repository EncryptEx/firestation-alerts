<?php 

namespace Utils; 

class User
{
    public function GetInfo($userId) {
        global $pdo;

        $SQL_SELECT = "SELECT * FROM `users` WHERE id=:id LIMIT 1";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['id'=> $userId];
        $selectStmt->execute($input);
        return $selectStmt->fetchAll()[0];
    }
}
