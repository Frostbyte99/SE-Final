<?php

//class
require('Class.php');

//Get info
$time = $_POST['time'];
$day = $_POST['day'];
$guestnum = $_POST['guestnum'];

//Create Object
$GetTableObj = new tables;
$GetTableObj->get_Guesttables($time, $day, $guestnum);
?>