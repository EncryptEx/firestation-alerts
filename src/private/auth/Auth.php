<?php 

/** 
 * Class to handle authentication
 * @author Jaume López (EncryptEx)
 */
namespace Utils;

class Auth
{
    public function login(string $email, string $rawPassword){
        global $pdo;
        $password = hash("SHA256", $rawPassword);

        $SQL_SELECT = "SELECT * FROM `users` WHERE email=:email AND password=:password LIMIT 1";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['email'=> $email, 'password'=>$password];
        $selectStmt->execute($input);

        if ($selectStmt->rowCount() > 0) {
            return [
                'success' => TRUE,
                'data' => $selectStmt->fetchAll()[0],
            ];
        }
        return ['success' => FALSE];
    }
    public function checkUserLogged($sessionId){
        if(!isset($sessionId)) {
            header('location:index.php');
            die();
        }
    }
    public function Register(string $name, string $email, string $rawPassword, string $tempToken, int $tokenExpiryTimestamp){
        global $pdo;
        $password = hash("SHA256", $rawPassword);

        $SQL_SELECT = "INSERT INTO `users` (id, name, email, password, status, tempToken, tokenExp) VALUES (NULL, :name, :email, :password, :status, :tempToken, :tokenExp)";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['name'=>$name, 'email'=> $email, 'password'=>$password, 'status'=>0, 'tempToken' => $tempToken, 'tokenExp' => $tokenExpiryTimestamp];
        return $selectStmt->execute($input);
    }
}

