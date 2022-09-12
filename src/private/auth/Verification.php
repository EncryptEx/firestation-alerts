<?php 

/** 
 * Class to handle account verification
 * @author Jaume López (EncryptEx)
 */
namespace Utils;
use PHPMailer\PHPMailer\PHPMailer; 

class Verification
{
    private function DoesTokenExist(string $token){
        global $pdo;

        $SQL_SELECT = "SELECT id FROM `users` WHERE tempToken=:tempToken LIMIT 1";
        $selectStmt = $pdo->prepare($SQL_SELECT);
        $input =   ['tempToken'=> $token];
        $selectStmt->execute($input);

        return boolval($selectStmt->rowCount());
    }
    public function CreateToken(int $length = 10){
        $doesTokenExist = true; // initially set to true to run the loop once minimum.
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        while ($doesTokenExist) {    
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $doesTokenExist = $this->DoesTokenExist($randomString);
        }
        return $randomString;
    }
    public function Send(string $recipientEmail, string $token){
        global $pdo;
        $emailTemplate = file_get_contents(__DIR__ . "/../templates/email.html");
        $mail = new PHPMailer();

        //Server settings
        $mail->isSMTP();
        $mail->SMTPDebug = 0; # Set 0 for non-debug, 2 for full debug.
        $mail->SMTPAuth = TRUE;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // tls implicit
        $mail->Port = $_ENV['MAIL_PORT']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`, ELSE 465  
        $mail->Username = $_ENV['MAIL_SENDER'];
        $mail->Password = $_ENV['MAIL_PWD'];
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->Mailer = "smtp";
        
        $mail->addAddress($recipientEmail);

        // email link 
        if (isset($_SERVER['HTTPS'])) {
            $extraS = "s";
        } else {
            $extraS = "";
        }
        $url = "http" . $extraS . "://" . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_FILENAME']), "", $_SERVER['PHP_SELF']); // if project is in subfolder, useful when coding in local with an ending / 


        $tokenUrl = $url . "/auth/verify.php?token=" . $token;

        //replace template's placeholder to real data
        $emailTemplate = str_replace("{{ tokenURL }}",  $tokenUrl, $emailTemplate);


        // Add custom name. from
        $mail->setFrom($_ENV['MAIL_SENDER'], 'Alerts');


        $mail->Body = trim($emailTemplate);

        $result = $mail->send();
        return $result;
    }
}

