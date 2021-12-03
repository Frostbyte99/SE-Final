<?php

//class
require('Class.php');

//Get login info
$time = $_POST['time'];
$day = $_POST['day'];
$guestnum = $_POST['guestnum'];

//set session var
//$_SESSION["pass_user"] = $user;

//Create Object
$GetTableObj = new tables;
$GetTableObj->get_tables($time, $day, $guestnum);
?>