<?php

require('class.php');

// Account variables from registration.html
$accountNumber = $_POST['accountnumber'];
$routingNumber = $_POST['routingnumber'];

$username = $_SESSION["pass_user"];

$updateAccount = new update;
$updateAccount->addCheck($username, $accountNumber, $routingNumber);

$card_redirect = new redirect;
$card_redirect->goto_login();
?>