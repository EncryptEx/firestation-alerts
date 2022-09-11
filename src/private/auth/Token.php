<?php 

/** 
 * Class to handle OTP Tokens
 * @author Jaume López (EncryptEx)
 */
namespace Utils;

class Token
{
    public function Create(){
        global $pdo;
        
        // check if new String does exist.
        $doesExist = true;
        while($doesExist) {
            $newToken = $this->getRandomString();
            $doesExist = $this->Check($newToken);
        }

        $SQL_INSERT = "INSERT INTO `tokens` (id, token, timestamp) VALUES (NULL, :token, :timestamp)";

        $insrtstmnt = $pdo->prepare($SQL_INSERT);

        $input = ['token' => $newToken, 'timestamp' => time()];

        
        if($insrtstmnt->execute($input)){
            return $newToken;
        } else{
            return false;
        }
        
    }
    public function Check(string $token){
        global $pdo;
        $SQL_SELECT = "SELECT * FROM `tokens` WHERE token=:token LIMIT 1";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['token'=> $token];
        $selectStmt->execute($input);

        return boolval($selectStmt->rowCount());
        
    }
    public function Delete($token){
        global $pdo;
        $SQL_SELECT = "DELETE FROM `tokens` WHERE token=:token";

        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['token' => $token];
        return $selectStmt->execute($input);
    }

    private function getRandomString($n=256) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }
}

