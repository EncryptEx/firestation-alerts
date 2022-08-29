<?php 

/** 
 * Class to handle authentication
 * @author Jaume López (EncryptEx)
 */
namespace Utils;

class Auth
{
    public function login(string $username, string $rawPassword){
        global $pdo;
        $password = hash("SHA256", $rawPassword);

        $SQL_SELECT = "SELECT * FROM `users` WHERE username=:username AND password=:password LIMIT 1";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['username'=> $username, 'password'=>$password];
        $selectStmt->execute($input);

        if ($selectStmt->rowCount() > 0) {
            return [
                'success' => TRUE,
                'data' => $selectStmt->fetch()[0],
            ];
        }
    }
}
