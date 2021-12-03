<?php

//class
require('Class.php');

//Get Var's
$cardnum = $_POST['card-number'];
$ccv = $_POST['ccv'];
$month = $_POST['Month'];
$year = $_POST['Year'];

//Create Object
$updatecard = new update;
$updatecard->updateActiveUserCard($cardnum, $ccv, $month, $year);
?>