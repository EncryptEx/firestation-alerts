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
                'data' => $selectStmt->fetch()[0],
            ];
        }
    }
    public function Register(string $name, string $email, string $rawPassword){
        global $pdo;
        $password = hash("SHA256", $rawPassword);

        $SQL_SELECT = "INSERT INTO `users` (id, name, email, password, status) VALUES (NULL, :name, :email, :password, :status)";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['name'=>$name, 'email'=> $email, 'password'=>$password, 'status'=>0];
        return $selectStmt->execute($input);
    }
}

