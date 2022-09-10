<?php
// extend session time
ini_set('session.gc_maxlifetime', 10800); 

session_start();

require_once('./../../private/utils.php');
$auth = new Utils\Auth();
$verification = new Utils\Verification();

// check for post payload
if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['email'])){
    header('location:login.php?e=1');
    die();
}

// name payloads
$entered_name = $_POST['name'];
$entered_email = $_POST['email'];
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header('location:login.php?e=1');
}

$encrypted_password = hash("SHA256", $_POST['password']);

// call DB and create user
$registerResult = $auth->Register($entered_name, $entered_email, $encrypted_password);
if(boolval($registerResult)) {
    // user created successfully
    // send verification email

    $verification->Send($entered_email);

    // print out the notification 
    header("location:./../login.php?s=1");
} else {
    // return errror
    header('location:./../login.php?e=2');
}

?>