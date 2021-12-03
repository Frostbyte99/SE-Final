<?php

require('class.php');

// Account variables from registration.html
$cardnumber = $_POST['card-number'];
$csc = $_POST['cvv'];
$cardyear = $_POST['Year'];
$cardmonth = $_POST['Month'];

$username = $_SESSION["pass_user"];

$updateAccount = new update;
$updateAccount->addCard($username, $cardnumber, $csc, $cardyear, $cardmonth);

$card_redirect = new redirect;
$card_redirect->goto_login();
?>