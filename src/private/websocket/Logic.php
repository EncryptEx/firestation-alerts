<?php
namespace websocket;
require_once './../utils.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Utils\Token;

class Notification implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $splitteddMsg = explode("|", $msg);
        // echo "Recieved NEW msg: " . $msg;
        // if(count($splitteddMsg) < 4){
            // return;
        // }
        echo "Recieved message\n";
        if($splitteddMsg[0] == "BROADCAST-ALERT"){
            // seems a msg, legit, but needs auth.
            if(hash('SHA256', $_ENV['HASH_SALT'] . $splitteddMsg[1] . $_ENV['HASH_SALT2']) == $splitteddMsg[2]){
                //hash verified, now check OTP
                $keySplitted = explode("otpToken", $splitteddMsg[1]);
                
                if(count($keySplitted) <=1){
                    echo "Not long enough\n";
                    return;
                }
                
                $token = new Token();
                echo "Checking OTP:". $keySplitted[1] . "\n";
                if(!$token->Check($keySplitted[1])){
                    echo "OTP not valid\n";
                    return; // old message, otp expired or not valid.
                }
            
                // authentiated, now broadcast message.
                foreach ($this->clients as $client) {
                    $client->send($splitteddMsg[3]);
                }
            
                echo "Sent message correctly!";
                $token->Delete($keySplitted[1]);
            }
        }
        // else, ignore
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}