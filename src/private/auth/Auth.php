<?php 

class Auth
{
    function __construct()
    {
        global $pdo;
        $charset = "UTF8MB4";
        $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
        $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // highly recommended
        PDO::ATTR_EMULATE_PREPARES => false // ALWAYS! ALWAYS! ALWAYS!
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
    }

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
                'data' => $selectStmt->(),
            ];
        }
    }
}
