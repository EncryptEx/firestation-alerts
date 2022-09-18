<?php
// extend session time
ini_set('session.gc_maxlifetime', 10800); 

session_start();

require_once('./../../private/utils.php');
use Utils\Auth;
$auth = new Auth();

// check for post payload
if(!isset($_POST['email']) || !isset($_POST['password'])){
    header('location:login.php?e=1');
    die();
}

// name payloads
$entered_email = $_POST['email'];
$encrypted_password = hash("SHA256", $_POST['password']);

// call DB and logn
$loginResult = $auth->Login($entered_email, $encrypted_password);
if(boolval($loginResult['success'])) {
    // do login stuff
    if($loginResult['data']['status'] == 0) {
        // email verification pending.
        header('location:./../login.php?e=3');
        die();
    }
    if($loginResult['data']['status'] == 1 || $loginResult['data']['status'] == 2) {
        // normal user
        $_SESSION['userId'] = $loginResult['data']['id'];
        $_SESSION['realName'] = $loginResult['data']['name'];
    }
    if($loginResult['data']['status'] == 2) {
        // is admin
        $_SESSION['is_admin'] = True;
    }
    if($loginResult['data']['status'] == 3) {
        // user banned
        header('location:./../login.php?e=5');
        die();
    }

    // no redirection so far.. 
    // redirect to dashboard.php
    header("location:./../dashboard.php");
} else {
    // return errror
    header('location:./../login.php?e=2');
}

?>
Redirecting...