<?php

// extend session time
ini_set('session.gc_maxlifetime', 10800);

session_start();

require_once('./../../private/utils.php');
$auth = new Utils\Auth();
$verification = new Utils\Verification();

// check for post payload
if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['email']) || !isset($_POST['countryCode'])) {
    header('location:./../register.php?e=1');
    die();
}

// name payloads
$entered_name = $_POST['name'];
$entered_email = $_POST['email'];
$countryCode = $_POST['countryCode'];
if (!filter_var($entered_email, FILTER_VALIDATE_EMAIL)) {
    header('location:./../register.php?e=1');
}

$encrypted_password = hash("SHA256", $_POST['password']);

// create a unique token
$validationToken = $verification->CreateToken();
$tokenExpirydate = time() + 86400; //expires in 24 hours
// call DB and create user
$registerResult = $auth->Register($entered_name, $countryCode, $entered_email, $encrypted_password, $validationToken, $tokenExpirydate);
if (boolval($registerResult)) {
    // user created successfully
    // send verification email

    $verification->Send($entered_email, $validationToken);

    // print out the notification
    header("location:./../register.php?s=1");
} else {
    // return errror
    header('location:./../register.php?e=2');
}
