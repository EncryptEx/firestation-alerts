<?php 

/** 
 * Class to handle account verification
 * @author Jaume López (EncryptEx)
 */
namespace Utils;

class Verification
{
    public function Send(string $rawPassword){
        global $pdo;
        $emailTemplate = file_get_contents(__DIR__ . "/../templates/email.html");
        
    }
}

