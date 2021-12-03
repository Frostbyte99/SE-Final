<?php

require('Class.php');

// Account variables from registration.html
$username = $_POST['username'];
$firstName = $_POST['firstname1'];
$lastName = $_POST['lastname1'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$favorite = $_POST['payment-method'];
$mailing = $_POST['MA'];
$billing = $_POST['BA'];

// Store username as global variable for this session
$_SESSION["pass_user"] = $username;
$_SESSION["MA"] = $mailing;
$_SESSION["BA"] = $billing;

// Create account object
$newAccount = new update;
$newAccount->makeAccount($username, $firstName, $lastName, $email, $phone, $password, $favorite);

$payment_redirect = new redirect;
if ($favorite == "card") {
    $payment_redirect->goto_registration_card();
} else if ($favorite == "check") {
    $payment_redirect->goto_registration_check();
} else {
    $payment_redirect->goto_login();
}
?>